@component('mail::message')
Hello,

This is an email to include the SCV file content.  

@component('mail::table')

| Subject          |        Message  |
|:----------------:|:---------------:|
| {{$mail['subject']}}   |  {{$mail['message']}} |
  
@endcomponent

Sincerely,
SCV File Sender.

@endcomponent