<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\MailReplaceRepositories;
use Modules\Horserace\Http\Requests\MailReplaceRequest;

class SystemController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function mailReplace(Request $request,
                              MailReplaceRepositories $mailReplaceRepositories)
  {
    $data['mail_replace'] = $mailReplaceRepositories->getListMailReplace();
    return view('horserace::backend.system.mail_replace', compact('data'));
  }

  public function addMailReplace(Request $request)
  {
    return view('horserace::backend.system.mail_replace_add');
  }

  public function storeMailReplace(MailReplaceRequest $request,
                                   MailReplaceRepositories $mailReplaceRepositories)
  {
    $input = $request->all();
    $result = $mailReplaceRepositories->mailReplaceStore($input);
    return redirect()->route('admin.mail_replace')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function editMailReplace(Request $request, $id,
                                  MailReplaceRepositories $mailReplaceRepositories)
  {
    $data['mail_replace'] = $mailReplaceRepositories->getEditMailReplace($id);
    return view('horserace::backend.system.mail_replace_edit', compact('data'));
  }

  public function deleteMailReplace(Request $request,
                                    MailReplaceRepositories $mailReplaceRepositories)
  {
    $input = $request->all();
    $result = $mailReplaceRepositories->deleteMailReplace(trim($input["id_delete"]));
    return redirect()->route('admin.mail_replace')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
}
