<h3>New Contact Form Message</h3>

<br/> <br/>

<b>Name : </b> {{ $name }} <br/><br/>
<b>Email : </b> {{ $email }}<br/><br/>
@if(!is_null($number))
  <b>Contact No. : </b> {{ $number }}<br/><br/>
@endif
<b>Subject : </b> {{ $subject }}<br/><br/>
<b>Message : </b> {{ $msg }}<br/><br/>
