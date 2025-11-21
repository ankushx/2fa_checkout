<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Usermanagement;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    protected $request;
    protected $resultFactory;
    protected $resultPageFactory;
    protected $twofautility;
    protected $messageManager;
    protected $logger;
    public function __construct(\Magento\Framework\App\RequestInterface $CvAKE, \Magento\Backend\App\Action\Context $YC5Py, \Magento\Framework\View\Result\PageFactory $v4SS4, \MiniOrange\TwoFA\Helper\TwoFAUtility $e4tn2, \Magento\Framework\Message\ManagerInterface $IWasp, \Psr\Log\LoggerInterface $WDIzu, ResultFactory $APmU3)
    {
        $this->request = $CvAKE;
        $this->resultPageFactory = $v4SS4;
        $this->twofautility = $e4tn2;
        $this->messageManager = $IWasp;
        $this->logger = $WDIzu;
        $this->resultFactory = $APmU3;
        parent::__construct($YC5Py, $v4SS4, $e4tn2, $IWasp, $WDIzu);
    }
    public function execute()
    {
        $E1mpB = $this->request->getPostValue();
        $Zqx71 = $this->twofautility->getCurrentAdminUser()->getEmail();
        $this->twofautility->isFirstPageVisit($Zqx71, "\x55\163\x65\162\40\115\141\x6e\141\147\145\x6d\x65\x6e\164");
        if (!$this->isFormOptionBeingSaved($E1mpB)) {
            goto RvB5d;
        }
        if (isset($E1mpB["\x73\x65\141\162\x63\x68"])) {
            goto kJeom;
        }
        if (isset($E1mpB["\162\x65\x73\145\x74"])) {
            goto UUC5j;
        }
        if (isset($E1mpB["\162\x65\x73\x65\x74\137\x64\x65\166\x69\x63\x65"])) {
            goto Rhqdn;
        }
        if (isset($E1mpB["\162\145\163\145\164\x5f\x73\x65\154\145\143\x74\145\144\137\x75\163\145\162\163"])) {
            goto opoox;
        }
        if (isset($E1mpB["\144\151\163\x61\142\154\x65\137\163\x65\x6c\145\x63\x74\145\144\137\x75\x73\x65\162\x73"])) {
            goto CWJpB;
        }
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_USERNAME, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_EMAIL, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_COUNTRYCODE, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_PHONE, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_ACTIVEMETHOD, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_CONFIGUREDMETHOD, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_WEBSITEID, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::USER_MANAGEMENT_DEVICE_INFORMATION, NULL);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        goto mYm6d;
        CWJpB:
        $FZfT7 = json_decode($E1mpB["\x61\x6c\154\x5f\165\163\x65\x72\x73\54\167\x65\x62\163\x69\x74\145\x5f\151\x64"], true);
        if (!(is_array($FZfT7) && !empty($FZfT7))) {
            goto ETOUE;
        }
        foreach ($FZfT7 as $user) {
            $vdQot = $user["\x65\155\141\151\x6c"];
            $fY0Er = $user["\x77\145\142\163\x69\164\145\137\x69\x64"];
            $E2wo_ = $this->twofautility->getAllMoTfaUserDetails("\155\151\x6e\151\157\162\x61\156\147\145\x5f\x74\x66\141\x5f\x75\x73\x65\x72\x73", $vdQot, $fY0Er);
            if (!(is_array($E2wo_) && sizeof($E2wo_) > 0)) {
                goto crWGi;
            }
            $XLIAW = $E2wo_[0]["\x69\x64"];
            $vYiSh = isset($E2wo_[0]["\x64\x69\163\x61\x62\x6c\x65\137\62\x66\x61"]) ? $E2wo_[0]["\144\151\163\141\142\x6c\145\137\x32\146\x61"] : false;
            $this->twofautility->updateColumnInTable("\x6d\x69\156\x69\157\x72\x61\156\x67\145\137\x74\x66\141\x5f\x75\163\x65\162\x73", "\x64\151\x73\x61\x62\154\145\137\62\146\141", !$vYiSh, "\165\163\145\x72\x6e\141\155\145", $vdQot, $fY0Er);
            $this->twofautility->flushCache();
            $this->twofautility->reinitConfig();
            crWGi:
            bgurQ:
        }
        GPSP6:
        ETOUE:
        $this->messageManager->addSuccessMessage("\x32\x46\101\x20\x73\x65\x74\x74\x69\x6e\147\x73\40\x66\x6f\x72\x20\164\x68\145\40\163\x65\154\x65\143\x74\x65\144\x20\x75\x73\x65\x72\163\40\150\141\x76\x65\x20\142\145\145\x6e\40\x63\150\141\156\147\x65\x20\163\x75\x63\x63\x65\163\x73\x66\x75\x6c");
        $udhT2 = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $udhT2->setPath("\155\157\x74\x77\157\x66\x61\57\x75\163\145\x72\155\141\156\x61\147\x65\155\x65\x6e\164\57\x69\x6e\144\145\170");
        return $udhT2;
        mYm6d:
        goto MN4Om;
        Rhqdn:
        $eyBIL = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_USERNAME);
        $HtvTf = $this->twofautility->getStoreConfig(TwoFAConstants::USER_MANAGEMENT_WEBSITEID);
        $E2wo_ = $this->twofautility->getAllMoTfaUserDetails("\155\151\x6e\151\x6f\x72\x61\x6e\x67\x65\137\x74\146\x61\137\165\163\145\x72\163", $eyBIL, $HtvTf);
        if (!(is_array($E2wo_) && sizeof($E2wo_) > 0 && isset($E2wo_[0]["\144\145\166\151\x63\x65\137\x69\x6e\146\x6f"]) && $E2wo_[0]["\144\145\166\x69\x63\x65\137\151\156\146\x6f"] != '')) {
            goto geLLH;
        }
        $p1h8r = $E2wo_[0]["\x64\145\166\x69\143\145\x5f\x69\x6e\x66\157"];
        $OtfoZ = json_decode($p1h8r, true);
        if (!isset($E1mpB["\x64\145\x76\x69\x63\x65\137\x69\x6e\144\145\x78"])) {
            goto NLG6H;
        }
        $CqhnA = $E1mpB["\x64\x65\166\151\x63\145\x5f\x69\x6e\144\x65\x78"];
        if (!isset($OtfoZ[$CqhnA])) {
            goto XTOyR;
        }
        unset($OtfoZ[$CqhnA]);
        $lOzoU = array_values($OtfoZ);
        $this->twofautility->updateColumnInTable("\x6d\x69\156\x69\157\x72\x61\156\x67\145\x5f\164\146\141\137\x75\163\x65\x72\163", "\144\145\166\x69\143\145\137\x69\x6e\146\157", json_encode($lOzoU), "\165\163\145\x72\x6e\x61\x6d\x65", $eyBIL, $HtvTf);
        XTOyR:
        NLG6H:
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        $this->messageManager->addSuccessMessage("\x59\157\x75\162\x20\125\x73\145\x72\40\104\145\x76\x69\x63\145\x20\x44\x65\164\x61\x69\154\x73\40\x68\x61\163\40\142\145\x65\156\x20\162\x65\x73\145\x74\40\163\165\143\143\x65\163\x73\146\x75\154\154\x79");
        $udhT2 = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $udhT2->setPath("\x6d\x6f\164\167\157\146\x61\57\x75\x73\x65\162\x6d\141\156\141\147\x65\x6d\145\156\164\57\x69\156\x64\x65\170");
        return $udhT2;
        geLLH:
        goto MN4Om;
        opoox:
        $FZfT7 = json_decode($E1mpB["\x61\x6c\x6c\x5f\x75\163\145\162\163\x2c\x77\x65\142\x73\x69\x74\x65\x5f\x69\144"], true);
        if (is_array($FZfT7) && !empty($FZfT7)) {
            goto RK5j4;
        }
        $this->messageManager->addErrorMessage("\x4e\x6f\x20\165\163\145\x72\x73\40\163\x65\154\x65\143\164\x65\144\x20\146\x6f\x72\x20\162\x65\163\145\164\164\151\156\147\x20\62\106\101\40\x73\x65\164\x74\x69\x6e\x67\163");
        goto XEjn3;
        RK5j4:
        foreach ($FZfT7 as $user) {
            $vdQot = $user["\145\x6d\141\x69\154"];
            $fY0Er = $user["\167\145\x62\x73\151\164\145\137\151\x64"];
            $E2wo_ = $this->twofautility->getAllMoTfaUserDetails("\x6d\151\156\151\157\x72\141\156\147\x65\x5f\164\146\x61\x5f\x75\x73\x65\x72\x73", $vdQot, $fY0Er);
            if (is_array($E2wo_) && sizeof($E2wo_) > 0) {
                goto Hg5Ya;
            }
            goto WMHsM;
            Hg5Ya:
            $XLIAW = $E2wo_[0]["\151\144"];
            $this->twofautility->deleteRowInTable("\155\x69\x6e\151\x6f\162\x61\156\147\145\137\x74\146\141\x5f\165\163\x65\x72\163", "\x69\144", $XLIAW);
            $this->twofautility->flushCache();
            $this->twofautility->reinitConfig();
            WMHsM:
            g5uqh:
        }
        nrQ45:
        $this->messageManager->addSuccessMessage("\62\x46\101\40\x73\145\x74\164\x69\x6e\x67\x73\40\146\157\162\x20\x74\x68\145\40\163\x65\x6c\x65\143\164\145\144\40\165\163\145\162\x73\x20\150\x61\166\145\x20\x62\x65\145\156\x20\x72\145\163\145\164\40\163\165\x63\143\x65\x73\x73\x66\x75\154\x6c\x79");
        XEjn3:
        $udhT2 = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $udhT2->setPath("\x6d\x6f\x74\x77\x6f\x66\x61\x2f\165\163\145\162\x6d\x61\x6e\x61\147\145\155\x65\156\x74\x2f\x69\156\x64\145\170");
        return $udhT2;
        MN4Om:
        goto IsPuH;
        kJeom:
        if (!isset($E1mpB["\x75\163\145\162\x5f\165\x73\x65\162\x6e\141\x6d\145"])) {
            goto OqAL6;
        }
        OqAL6:
        goto IsPuH;
        UUC5j:
        $vdQot = $E1mpB["\145\x6d\x61\151\154"];
        $fY0Er = $E1mpB["\x77\x65\142\x73\x69\x74\145\137\151\x64"];
        $E2wo_ = $this->twofautility->getAllMoTfaUserDetails("\155\x69\x6e\151\x6f\162\141\x6e\x67\145\137\164\x66\141\x5f\165\x73\x65\x72\x73", $vdQot, $fY0Er);
        if (!(is_array($E2wo_) && sizeof($E2wo_) > 0)) {
            goto UI2uO;
        }
        $XLIAW = $E2wo_[0]["\151\x64"];
        $this->twofautility->deleteRowInTable("\x6d\x69\156\x69\157\x72\x61\156\x67\145\x5f\x74\x66\x61\x5f\x75\x73\x65\162\163", "\151\x64", $XLIAW);
        $this->twofautility->flushCache();
        $this->twofautility->reinitConfig();
        $this->messageManager->addSuccessMessage("\131\157\x75\x72\40\125\x73\x65\x72\x20\x44\x65\x74\141\x69\x6c\x73\40\x68\x61\x73\x20\x62\x65\145\156\40\162\x65\x73\145\x74\x20\x73\x75\143\x63\x65\x73\163\x66\x75\x6c\154\171");
        $udhT2 = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $udhT2->setPath("\155\x6f\x74\167\157\x66\x61\x2f\x75\163\145\x72\155\x61\x6e\141\147\x65\155\x65\156\x74\57\x69\x6e\144\145\x78");
        return $udhT2;
        UI2uO:
        IsPuH:
        RvB5d:
        $BS82J = $this->resultPageFactory->create();
        $BS82J->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $BS82J;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_USER_MANAGEMENT);
    }
}