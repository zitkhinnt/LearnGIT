<html>
<head>
  <title>{{ FILE_USER_REGISTER_MAIL }}</title>
</head>
<body>
<!-- header table -->
<table>
  <thead>
  <tr>
    <th align="center">{{ __("horserace::be_form.mail_address") }}</th>
    <th align="center">{{ __("horserace::be_form.ip_address") }}</th>
  </tr>
  </thead>

  @foreach($data_user as $item)
    <tr>
    <td>
      @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
      {{ replaceStringEmail($item->mail_pc) }}
      @else
      {{ $item->mail_pc }}
      @endif
      </td>
      <td>{{ $item->ip }}</td>
    </tr>
  @endforeach


</table>

</body>
</html>