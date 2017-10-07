<?php

class Common_SignFilter implements PhalApi_Filter {

    public function check() {

        if (DI()->request->get('__debug__') == '1') {
            return;
        }

      $Domain_Users = new Domain_Users();
      $domain = DI()->request->get('domain');
      $key =  DI()->request->get('key');
      $is_url = strpos($domain,"http://");

      if($is_url!==false){
        DI()->loginLite->m_glype_porxy =  $domain."/glype/browse.php?u={url}&b=12&f=norefer";
      }


      //密钥是否正确
      if (!$Domain_Users->isJoinIn($domain,$key)) {
          throw new PhalApi_Exception_BadRequest(T('wrong sign'));
      }
    }
}
