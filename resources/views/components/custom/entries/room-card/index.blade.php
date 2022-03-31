@props([
    $roomId,
    $roomNumber,
])

<div class="col-lg-3 col-md-6 col-12 mb-3">
    <div x-data="roomcard{{ $roomId }}" x-bind="listener" x-ref="card" class="card h-100">
        <x-custom.entries.room-card.header />
        <x-custom.entries.room-card.body />
    </div>
</div>

@push('css')
    <x-authorization-js />

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('roomcard{{ $roomId }}', () => ({
                id: @json($roomId),
                number: @json($roomNumber),
                occupied: 0,
                selected: 0,
                latest_entry: {
                    id: 0,
                    overnight: false,
                    entry_time: '',
                    expected_exit_time: '',
                    remaining_time: {}
                },
                occupied_text: '',
                overnight_text: '',
                entry_time_text: '',
                expected_exit_time_text: '',
                remaining_time_text: '',
                init(){
                    this.setVisibility();
                },
                listener: {
                    ['x-on:notify-{{ $roomId }}.window'](event){
                        this.setOccupied(event.detail.occupied);
                        this.setSelected(event.detail.selected);

                        if(this.occupied && event.detail.latest_entry){
                            this.setOvernight(event.detail.latest_entry.overnight);
                            this.setEntryTime(event.detail.latest_entry.entry_time);
                            this.setExpectedExitTime(
                                event.detail.latest_entry.overnight ?
                                    event.detail.latest_entry.expected_exit_time :
                                    event.detail.latest_entry.expected_exit_time_with_addition
                                );
                            this.setRemainingTime(event.detail.latest_entry.remaining_time);
                            this.setEditLink(event.detail.latest_entry.id);
                        }else{
                            this.setOvernight(null);
                            this.setEntryTime(null);
                            this.setExpectedExitTime(null);
                            this.setRemainingTime(null);
                            this.setCreateLink();
                        }

                        // this.$refs.card.style.minHeight = '370px';
                    },
                },

                setOccupied(value){
                    if(value === null){
                        this.$refs.occupied_wrapper.style.display = 'none';
                        this.occupied = false;
                        this.occupied_text = 0;
                        return;
                    }

                    this.occupied = !!value;
                    this.occupied_text = this.occupied ? 'Ocupado' : 'Livre';
                    this.setBackground();
                },
                setSelected(value){
                    if(value === null){
                        this.selected = false;
                        return;
                    }

                    this.selected = !!value;
                },
                setOvernight(value){
                    if(value === null){
                        this.$refs.overnight_wrapper.style.display = 'none';
                        this.latest_entry.overnight = false;
                        this.overnight_text = '';
                        return;
                    }
                    this.latest_entry.overnight = !!value;
                    this.overnight_text = this.latest_entry.overnight ? 'Sim' : 'Não';
                    this.$refs.overnight_wrapper.style.display = 'block';
                },
                setEntryTime(value){
                    if(value === null){
                        this.$refs.entry_time_wrapper.style.display = 'none';
                        this.latest_entry.entry_time = '';
                        this.entry_time_text = '';
                        return;
                    }
                    this.latest_entry.entry_time = value;
                    this.entry_time_text = moment(value)
                                                    .format('DD/MM/YYYY HH:mm:ss');
                    this.$refs.entry_time_wrapper.style.display = 'block';
                },
                setExpectedExitTime(value){
                    if(value === null){
                        this.$refs.expected_exit_time_wrapper.style.display = 'none';
                        this.latest_entry.expected_exit_time = '';
                        this.expected_exit_time_text = '';
                        return;
                    }
                    this.latest_entry.expected_exit_time = value;
                    this.expected_exit_time_text = moment(value)
                                                    .format('DD/MM/YYYY HH:mm:ss');
                    this.$refs.expected_exit_time_wrapper.style.display = 'block';
                },
                setRemainingTime(object){
                    if(object === null){
                        this.$refs.remaining_time_wrapper.style.display = 'none';
                        this.latest_entry.remaining_time = '';
                        this.$refs.remaining_time.classList.remove(['bg-success', 'bg-warning', 'bg-danger']);
                        return;
                    }

                    if(!this.occupied){ return; }

                    let { negative, y, m, d, h, i, s } = object;
                    let text = '';
                    let backgroundClass = '';

                    text += this.getRemainingTimeStartText(negative);
                    text += this.getYearsAsHuman(y);
                    text += this.getDaysAsHuman(m);
                    text += this.getDaysAsHuman(d);

                    text += this.getTimeString(h, i, s);

                    this.$refs.remaining_time.classList.remove(['bg-success', 'bg-warning', 'bg-danger']);

                    backgroundClass = this.getRemainingTimeBgClass(negative, y, m, d, h, i);
                    this.$refs.remaining_time.classList.add(backgroundClass);

                    this.remaining_time_text = text;
                    this.$refs.remaining_time_wrapper.style.display = 'block';
                },
                getTimeString(hour, min, sec){
                    return String(hour).padStart(2, '0') + ':' +
                            String(min).padStart(2, '0') + ':' +
                            String(sec).padStart(2, '0');
                },
                getYearsAsHuman(value){
                    if(!value) return '';
                    return value === 1 ? '1 ano, ' : value + ' anos, ';
                },
                getMounthsAsHuman(value){
                    if(!value) return '';
                    return value === 1 ? '1 mês, ' : value + ' meses, ';
                },
                getDaysAsHuman(value){
                    if(!value) return '';
                    return value === 1 ? '1 dia, ' : value + ' dias, ';
                },
                getRemainingTimeBgClass(negative, year, month, day, hour, minutes){
                    if(negative){
                        backgroundClass = 'badge-danger';
                    }else{
                        backgroundClass = 'badge-success';

                        if(year == 0 && month == 0 && day == 0 && hour == 0 &&
                            minutes <= 30
                        ){
                            backgroundClass = 'badge-warning';
                        }
                    }

                    return backgroundClass;
                },
                getRemainingTimeStartText(negative){
                    return negative ? 'Já se passaram ' : 'Faltam ';
                },
                setBackground(){
                    if(this.occupied){
                        this.$refs.card.style.backgroundColor = '#F87171';
                    }else{
                        this.$refs.card.style.backgroundColor = '#4ADE80';
                    }
                },
                setCreateLink(){
                    this.$refs.link.innerText = 'Selecionar';
                    this.$refs.link.classList.remove('btn-success', 'btn-danger');
                    this.$refs.link.classList.add('btn-success');
                    this.$refs.link.href = '/sistema/entradas/' + this.id + '/criar';
                },
                setEditLink(id){
                    this.$refs.link.innerText = 'Gerenciar';
                    this.$refs.link.classList.remove('btn-success', 'btn-danger');
                    this.$refs.link.classList.add('btn-danger');
                    this.$refs.link.href = '/sistema/entradas/' + id + '/editar';
                },
                setVisibility(){
                    if(this.$store.roles.has('user-operator') ||
                        this.$store.roles.has('system-admin')
                    ){
                        return;
                    }
                    this.$refs.link.style.display = 'none';
                },
            }));
        });
    </script>
@endpush