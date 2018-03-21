SMS response:
@if(isset($data['member']))
<p>From: {{ $data['member']->first or ''}} {{ $data['member']->last or ''}}</p>
@else
<p>From: {{ $data['msisdn'] or ''}}</p>
@endif
<p>Message: {{ $data['text'] or ''}}</p>
<p>When: {{ $data['message-timestamp'] or ''}}</p>