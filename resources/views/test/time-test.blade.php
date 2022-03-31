@dump($entry)
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;{{ now() }} <-- Horário atual<br>
&nbsp;&nbsp;&nbsp;&nbsp;{{ $entry->entry_time }} <-- Hora entrada <br>
&nbsp;&nbsp;&nbsp;&nbsp;{{ $entry->expected_exit_time }} <-- Hora esperada de saída<br>
&nbsp;&nbsp;&nbsp;&nbsp;{{ $entry->expected_exit_time_with_addition }} <-- Hora esperada de saída com adição 10min<br>
&nbsp;&nbsp;&nbsp;&nbsp;{{ $entry->additional_hours }} <-- Horas adicionais<br>