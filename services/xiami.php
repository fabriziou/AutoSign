<?php
/**
 * 虾米网签到
 * @author Newton <mciguu@gmail.com>
 */
class XiaMi extends Sign
{
	//唯一实例静态变量
	protected static $_instance = NULL;

	//服务名称前缀
	protected $preFix = 'XiaMi_';

	//cookie 存在标识
	protected $isCookieExist = true;

	//登录 URL
	private $homeUrl = 'http://www.xiami.com/';
	private $loginUrl = 'http://www.xiami.com/member/login';

	//签到 URL
	private $signUrl = 'http://www.xiami.com/task/signin';

	/**
	 * 签到方法
	 */
	public function sign()
	{
		if(!$this->isCookieExist)
		{
			// $this->get($this->loginUrl);
			$data = array(
				'email'=>$this->username,
				'password'=>$this->password,
				'autologin'=>1,
				'submit'=>'登 录',
				'done'=>'/',
				'type'=>''
				);
			$loginResp = $this->post($this->loginUrl, $data);
		}
		// else
		// 	$this->get($this->homeUrl);

		$header = array(
			'Host: www.xiami.com',
			'Referer: http://www.xiami.com/',
			'X-Requested-With: XMLHttpRequest',
			);
		$signResp = $this->post($this->signUrl, array(), $header);
		if(empty($signResp) || intval($signResp) < 1)
			$this->retry();

		$this->logLine .= self::SIGNED.' 已连续签到 '.$signResp.' 天';
	}
}

?>