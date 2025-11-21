<?php

namespace MiniOrange\TwoFA\Observer;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use MiniOrange\TwoFA\Controller\Actions\AdminLoginAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use Psr\Log\LoggerInterface;
class TwoFAObserver implements ObserverInterface
{
    private $requestParams = array("\x6f\160\164\x69\157\x6e");
    private $messageManager;
    private $logger;
    private $twofautility;
    private $adminLoginAction;
    private $currentControllerName;
    private $currentActionName;
    private $request;
    public function __construct(ManagerInterface $N5rFg, LoggerInterface $K4xFe, \MiniOrange\TwoFA\Helper\TwoFAUtility $wRmI5, AdminLoginAction $sZ6kv, Http $VAgjy, RequestInterface $Ft1EL)
    {
        $this->messageManager = $N5rFg;
        $this->logger = $K4xFe;
        $this->twofautility = $wRmI5;
        $this->adminLoginAction = $sZ6kv;
        $this->currentControllerName = $VAgjy->getControllerName();
        $this->currentActionName = $VAgjy->getActionName();
        $this->request = $Ft1EL;
    }
    private function _route_data($ASZtG, $T_mAM, $xZr3l, $Q19gV)
    {
        switch ($ASZtG) {
            case $this->requestParams[0]:
                if (!($xZr3l["\x6f\160\x74\151\157\156"] == TwoFAConstants::LOGIN_ADMIN_OPT)) {
                    goto qu1He;
                }
                $this->adminLoginAction->execute();
                qu1He:
                goto pFPhl;
        }
        Rku81:
        pFPhl:
    }
    public function execute(Observer $T_mAM)
    {
        $cw735 = $T_mAM->getEvent();
        $Nay2L = $cw735->getCustomer();
        $SlEoA = $Nay2L->getEmail();
        $this->twofautility->deleteRowInTableWithWebsiteID("\155\x69\x6e\151\157\x72\x61\156\147\x65\137\x74\x66\141\137\x75\163\145\162\x73", "\x75\x73\145\162\156\141\x6d\x65", $SlEoA, $Nay2L->getData()["\x77\145\x62\x73\x69\164\145\137\151\x64"]);
        return;
    }
}