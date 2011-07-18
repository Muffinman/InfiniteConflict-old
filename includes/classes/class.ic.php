<?

class IC {

  protected $db;
  var $smarty;

  function __construct($db){
    $this->db = $db;
  }

  function LoadSession($id){
    $q = "SELECT * FROM session WHERE session_id='" . $this->db->esc($id) . "' LIMIT 1";
    if ($r = $this->db->Select($q)){
      return $r[0];
    }
    return false;
  }

  function LoadRuler($id){
    return $this->db->QuickSelect('ruler', $id);
  }

  function SendEmail($to, $subject, $template){

    $email_body = $this->smarty->fetch('email/' . $template);
    $this->smarty->assign('email_body', $email_body);
    $body = $this->smarty->fetch('email/layout.tpl');

    $mail = new PHPMailerLite();
    $mail->IsHTML(true);

    $mail->Body = $body;

    $mail->Subject = $subject;
    $mail->From = 'noreply@infiniteconflict.com';
    $mail->FromName = 'Infinite Conflict';

    if (is_array($to)){
      foreach ($to as $address){
        $mail->AddAddress($address);
      }
    }else{
      $mail->AddAddress($to);
    }
    $mail->AddBCC('admin@infiniteconflict.com', 'IC Admin');

    if ($mail->Send()){
      return true;
    }
    return false;
  }

  function LoadNextHomeplanet(){
    $q = "SELECT * FROM planet WHERE ruler_id IS NULL AND home=1 ORDER BY id ASC LIMIT 1";
    if ($r = $this->db->Select($q)){
      return $r[0];
    }
  }

}

?>