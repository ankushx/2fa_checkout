<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseFactory;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class CustomerLoginAction extends BaseAction implements HttpPostActionInterface
{
    private $user;
    private $customerSession;
    private $responseFactory;
    public function __construct(Context $d2Lsn, twofautility $JApDh, Session $XGyVE, ResponseFactory $qmYq1)
    {
        $this->customerSession = $XGyVE;
        $this->responseFactory = $qmYq1;
        parent::__construct($d2Lsn, $JApDh);
    }
    public function execute()
    {
        $dmBKY = $this->twofautility->getBaseUrl() . "\x63\165\163\164\x6f\155\x65\x72\57\x61\143\x63\157\165\156\x74";
        $this->twofautility->log_debug("\103\x75\163\164\157\155\x65\x72\x4c\x6f\x67\151\x6e\x41\x63\x74\151\x6f\156\72\x20\x65\170\145\143\x75\x74\145");
        $this->customerSession->setCustomerAsLoggedIn($this->user);
        return $this->getResponse()->setRedirect($this->twofautility->getUrl($dmBKY))->sendResponse();
    }
    public function setUser($user)
    {
        $this->twofautility->log_debug("\103\165\163\x74\x6f\155\x65\162\x4c\x6f\147\151\x6e\x41\143\164\151\157\156\72\40\x73\x65\164\125\x73\x65\162");
        $this->user = $user;
        return $this;
    }
}