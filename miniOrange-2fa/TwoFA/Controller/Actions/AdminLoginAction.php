<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use Magento\Framework\App\Action\HttpPostActionInterface;
class AdminLoginAction extends BaseAction implements HttpPostActionInterface
{
    protected $_resultPage;
    private $relayState;
    private $user;
    private $adminSession;
    private $cookieManager;
    private $adminConfig;
    private $cookieMetadataFactory;
    private $adminSessionManager;
    private $urlInterface;
    private $userFactory;
    private $request;
    public function __construct(\Magento\Framework\App\Action\Context $lTDwe, \MiniOrange\TwoFA\Helper\TwoFAUtility $TN2cn, \Magento\Backend\Model\Auth\Session $rqH_i, \Magento\Framework\Stdlib\CookieManagerInterface $jINrT, \Magento\Backend\Model\Session\AdminConfig $IPRIX, \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $CoVie, \Magento\Security\Model\AdminSessionsManager $Ku4Pp, \Magento\Backend\Model\UrlInterface $GkCWS, \Magento\User\Model\UserFactory $lEnWX, \Magento\Framework\App\RequestInterface $rBAB9)
    {
        $this->adminSession = $rqH_i;
        $this->cookieManager = $jINrT;
        $this->adminConfig = $IPRIX;
        $this->cookieMetadataFactory = $CoVie;
        $this->adminSessionManager = $Ku4Pp;
        $this->urlInterface = $GkCWS;
        $this->userFactory = $lEnWX;
        $this->request = $rBAB9;
        parent::__construct($lTDwe, $TN2cn);
    }
    public function execute()
    {
        $this->twofautility->log_debug("\101\x64\155\151\156\x4c\x6f\147\151\x6e\x41\x63\x74\151\x6f\156\x3a\x20\x65\170\145\143\165\164\x65");
        $AlOt3 = $this->request->getParams();
        $user = $this->userFactory->create()->load($AlOt3["\x75\163\145\x72\x69\144"]);
        $this->adminSession->setUser($user);
        $this->adminSession->processLogin();
        if (!$this->adminSession->isLoggedIn()) {
            goto VtWyZ;
        }
        $NS4K9 = $this->adminSession->getSessionId();
        if (!$NS4K9) {
            goto bPzYm;
        }
        $NXcSi = str_replace("\141\165\164\157\x6c\x6f\147\x69\156\x2e\x70\150\x70", "\151\x6e\x64\145\x78\56\160\x68\160", $this->adminConfig->getCookiePath());
        $YxJ8s = $this->cookieMetadataFactory->createPublicCookieMetadata()->setDuration(3600)->setPath($NXcSi)->setDomain($this->adminConfig->getCookieDomain())->setSecure($this->adminConfig->getCookieSecure())->setHttpOnly($this->adminConfig->getCookieHttpOnly());
        $this->cookieManager->setPublicCookie($this->adminSession->getName(), $NS4K9, $YxJ8s);
        $this->adminSessionManager->processLogin();
        bPzYm:
        VtWyZ:
        $BabQi = $this->urlInterface->getStartupPageUrl();
        $k8LyY = $this->urlInterface->getUrl($BabQi);
        $k8LyY = str_replace("\141\165\164\157\154\x6f\x67\151\x6e\56\x70\150\x70", "\151\x6e\144\x65\x78\x2e\x70\150\x70", $k8LyY);
        return $this->resultRedirectFactory->create()->setUrl($k8LyY);
    }
}