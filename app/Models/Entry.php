<?php

namespace App\Models;

use App\Events\EntryFinished;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entry extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'expected_exit_time',
        'expected_exit_time_with_addition',
        'remaining_time',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_plate', 'entry_time', 'room_id', 'overnight', 'room_price',
        'room_price_per_additional_hour', 'finished'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'entry_time' => 'immutable_datetime',
        'exit_time' => 'immutable_datetime',
    ];

    /**
     * Obtem o quarto que possuí a entrada
     *
     * @return void
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Obtem a ordem associada a entrada
     *
     * @return void
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * O tempo remanescente do horário de saída.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function remainingTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->overnight) {
                    $expectedExitTime = $this->expected_exit_time;
                } else {
                    $expectedExitTime = $this->expected_exit_time_with_addition;
                }

                $interval = (new Carbon($this->final_time))
                    ->diff(new Carbon($expectedExitTime));

                if ($interval->invert) {
                    $negative = true;
                } else {
                    $negative = false;
                }

                return [
                    'negative' => $negative,
                    'y' => $interval->y,
                    'm' => $interval->m,
                    'd' => $interval->d,
                    'h' => $interval->h,
                    'i' => $interval->i,
                    's' => $interval->s,
                ];
            }
        );
    }

    /**
     * O valor total das horas adicionais. Que representa a multiplicação das
     * horas adicionais contabilizadas por o preço por hora adicional
     *
     * @return Attribute
     */
    protected function totalAdditionalHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                return bcmul(
                    $this->additional_hours,
                    $this->room_price_per_additional_hour,
                    2
                );
            }
        );
    }

    /**
     * O valor total do serviço. Que representa o valor do quarto mais a
     * quantidade de horas passadas vezes o valor da hora adicional
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: function () {
                return bcadd(
                    $this->room_price,
                    $this->total_additional_hours,
                    2
                );
            }
        );
    }

    /**
     * O tempo esperado de saída, que é o tempo de entrada somado com 2h, ou,
     * caso pernoite, somado a 12h
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function expectedExitTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                $hours = $this->overnight ? 12 : 2;
                return $this->entry_time
                    ->addHours($hours)
                    ->toImmutable();
            }
        );
    }

    /**
     * O tempo esperado de saída com adição de 11 minutos
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function expectedExitTimeWithAddition(): Attribute
    {
        return Attribute::make(
            get: function () {
                return (new Carbon($this->expected_exit_time))
                    ->addMinutes(11)
                    ->toImmutable();
            }
        );
    }

    /**
     * As horas adicionais contabilizadas depois do tempo padrão do quarto
     * (depois de 2h 11min se normal ou 12h se pernoite)
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function additionalHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                $finalTime = new Carbon($this->final_time);
                $expectedExitTimeWithAddition = new Carbon($this->expected_exit_time_with_addition);

                if ($finalTime->isAfter($expectedExitTimeWithAddition)) {
                    $additionalHours = 1;
                } else {
                    return 0;
                }

                $additionalHours += (new Carbon($this->expected_exit_time))->diffInHours($finalTime, false);

                return $additionalHours;
            }
        );
    }

    /**
     * Retorna os minutos que faltam para a contabilização da próxima hora
     * adicional
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function minutesLeftToNextAdditionalHour(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = Carbon::now();
                $target = $this->expected_exit_time;

                if ($now->isBefore($target->subMinutes(45))) {
                    return false;
                }

                if (!$this->overnight && $now->isBetween($target->addMinutes(11)->subHour(), $target->addMinutes(11))) {
                    $target = $target->addMinutes(11);
                }

                if ($target->isAfter($now)) {
                    $diff = $now->diffAsCarbonInterval($target, false);
                    $reduce = 0;
                } else {
                    $diff = $target->diffAsCarbonInterval($now, false);
                    $reduce = 60;
                }

                return abs($reduce - $diff->i);
            }
        );
    }

    public function firstAdditionalHour(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->overnight) return false;

                return Carbon::now()->between(
                    $this->expected_exit_time_with_addition->subHour(),
                    $this->expected_exit_time_with_addition
                );
            }
        );
    }

    /**
     * Se a entrada já ter sido finalizada retorna a data hora do momento da
     * saída, se não retorna a data hora atual
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function finalTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->finished ? new Carbon($this->exit_time) : Carbon::now();
            }
        );
    }

    /**
     * Finaliza a entrada
     *
     * @return void
     */
    public function finish()
    {
        $this->finished = true;
        $this->exit_time = Carbon::now();
        $this->save();
        EntryFinished::dispatch($this);
    }

    /**
     * Seta os preços da entrada atual com os valores dos preços do quarto que
     * possuí relação com a entrada
     *
     * @return void
     */
    public function setPricesThroughRoom()
    {
        $room = $this->room;
        $this->room_price = $room->price;
        $this->room_price_per_additional_hour = $room->price_per_additional_hour;
    }

    public function minutesLeftToFirstAdditionalHour(): Attribute
    {
        return Attribute::make(
            get: function () {
                return 60 - $this->expected_exit_time_with_addition
                    ->subHour()
                    ->diffInMinutes(Carbon::now()) % 60;
            }
        );
    }
}
