<html>
<head>
  <title>{{ FILE_USER_INTERIM_MAIL }}</title>
</head>
<body>
<!-- header table -->
<table>
  <thead>
  <tr>
    <th align="center">{{ __("horserace::be_form.mail_address") }}</th>
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
    </tr>
  @endforeach


</table>

</body>
</html>