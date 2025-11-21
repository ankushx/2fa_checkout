<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Support;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\ResultFactory;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\Curl;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    protected $fileFactory;
    public function __construct(Context $Vn1q_, \MiniOrange\TwoFA\Helper\TwoFAUtility $Xlurw, \Magento\Framework\View\Result\PageFactory $kf3M3, \Magento\Framework\Message\ManagerInterface $Czl26, \Psr\Log\LoggerInterface $BX9qQ, FileFactory $JEEPL)
    {
        parent::__construct($Vn1q_, $kf3M3, $Xlurw, $Czl26, $BX9qQ);
        $this->fileFactory = $JEEPL;
    }
    public function execute()
    {
        try {
            $p2KlN = $this->getRequest()->getParams();
            if (!$this->isFormOptionBeingSaved($p2KlN)) {
                goto wxUQc;
            }
            if (!(isset($p2KlN["\x73\x65\156\144\137\x71\x75\x65\x72\171"]) && $p2KlN["\163\x65\156\144\x5f\161\x75\145\x72\171"] == "\123\165\x62\x6d\151\164\40\121\x75\x65\162\171")) {
                goto HnF61;
            }
            $this->checkIfSupportQueryFieldsEmpty(["\x65\155\141\151\x6c" => $p2KlN, "\x71\165\x65\162\171" => $p2KlN]);
            $pUe_u = $p2KlN["\145\155\x61\x69\x6c"];
            $reeiv = $p2KlN["\160\150\x6f\x6e\x65"];
            $Du2Kz = $p2KlN["\161\165\x65\x72\171"];
            Curl::submit_contact_us($pUe_u, $reeiv, $Du2Kz);
            $this->messageManager->addSuccessMessage(TwoFAMessages::QUERY_SENT);
            HnF61:
            if (isset($p2KlN["\157\x70\164\x69\157\156"]) && $p2KlN["\157\x70\x74\151\157\x6e"] == "\145\x6e\x61\142\x6c\x65\x5f\x64\145\x62\165\147\137\x6c\157\x67") {
                goto CUma8;
            }
            if (isset($p2KlN["\x6f\x70\164\151\x6f\x6e"]) && $p2KlN["\x6f\160\164\x69\157\x6e"] == "\143\x6c\145\x61\162\137\x64\157\x77\x6e\x6c\157\141\x64\137\154\157\x67\x73") {
                goto b9_P4;
            }
            goto nZ11p;
            CUma8:
            $nysPm = isset($p2KlN["\x64\x65\142\x75\147\x5f\154\157\147\x5f\157\x6e"]) ? 1 : 0;
            $Z9mI1 = time();
            $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_DEBUG_LOG, $nysPm);
            $this->twofautility->flushCache();
            $this->twofautility->reinitConfig();
            if ($nysPm == "\61") {
                goto eLQxk;
            }
            if ($nysPm == "\60" && $this->twofautility->isCustomLogExist()) {
                goto YaETz;
            }
            goto cOwaN;
            eLQxk:
            $this->twofautility->setStoreConfig(TwoFAConstants::LOG_FILE_TIME, $Z9mI1);
            goto cOwaN;
            YaETz:
            $this->twofautility->setStoreConfig(TwoFAConstants::LOG_FILE_TIME, NULL);
            $this->twofautility->deleteCustomLogFile();
            cOwaN:
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            goto nZ11p;
            b9_P4:
            if (isset($p2KlN["\x64\157\167\x6e\154\x6f\141\x64\x5f\154\157\x67\x73"])) {
                goto IjAgW;
            }
            if (isset($p2KlN["\x63\x6c\145\141\x72\137\x6c\157\147\x73"])) {
                goto VghS6;
            }
            goto Pcjoz;
            IjAgW:
            $IYqPp = "\x6d\157\x5f\164\167\157\x66\141\x2e\154\x6f\147";
            if ($IYqPp) {
                goto LAAHi;
            }
            $this->messageManager->addErrorMessage("\x53\157\155\145\164\150\151\x6e\x67\x20\x77\145\x6e\164\40\x77\x72\157\156\147");
            goto eDq1_;
            LAAHi:
            $lDly7 = "\56\x2e\57\166\141\x72\57\x6c\157\x67\x2f" . $IYqPp;
            $em0DV["\164\x79\x70\145"] = "\x66\151\x6c\x65\156\x61\x6d\x65";
            $em0DV["\166\141\154\165\145"] = $lDly7;
            $em0DV["\x72\x6d"] = 0;
            if (!$this->twofautility->isLogEnable()) {
                goto jMdP7;
            }
            $this->customerConfigurationSettings();
            jMdP7:
            if ($this->twofautility->isCustomLogExist() && $this->twofautility->isLogEnable()) {
                goto XWFj0;
            }
            $this->messageManager->addErrorMessage("\120\154\x65\141\163\145\x20\x45\x6e\x61\142\154\145\x20\x44\x65\x62\x75\x67\x20\x4c\157\147\40\123\145\x74\x74\151\156\147\40\106\x69\x72\163\x74");
            goto Er2u9;
            XWFj0:
            return $this->create_log_file($IYqPp, $em0DV);
            Er2u9:
            eDq1_:
            goto Pcjoz;
            VghS6:
            if ($this->twofautility->isCustomLogExist()) {
                goto Y_avI;
            }
            $this->messageManager->addSuccessMessage("\114\157\147\x73\40\110\x61\x76\145\40\x41\x6c\x72\145\141\x64\171\x20\x42\145\x65\x6e\x20\x52\145\x6d\x6f\x76\145\144");
            goto KnMCb;
            Y_avI:
            $this->twofautility->setStoreConfig(TwoFAConstants::LOG_FILE_TIME, NULL);
            $this->twofautility->deleteCustomLogFile();
            $this->messageManager->addSuccessMessage("\114\157\147\x73\x20\103\x6c\145\x61\162\145\144\40\x53\x75\143\x63\145\x73\163\x66\165\154\154\171");
            KnMCb:
            Pcjoz:
            nZ11p:
            wxUQc:
        } catch (\Exception $VTfxa) {
            $this->messageManager->addErrorMessage($VTfxa->getMessage());
            $this->logger->debug($VTfxa->getMessage());
        }
        $PiPxi = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $PiPxi->setUrl($this->_redirect->getRefererUrl());
        return $PiPxi;
    }
    private function customerConfigurationSettings()
    {
        $QCWeY = $this->twofautility->getStoreConfig(TwoFAConstants::DEFAULT_MAP_EMAIL);
        $this->twofautility->customlog("\x2e\x2e\x2e\56\56\x2e\x2e\x2e\56\56\x2e\56\x2e\56\x2e\56\56\x2e\56\56\56\x2e\56\x2e\56\x2e\x2e\56\x2e\x2e\x2e\56\56\x2e\56\56\x2e\56\56\x2e\x2e\56\x2e\56\56\x2e\56\56\56\56\56\x2e\x2e\x2e\x2e\56\56\x2e\x2e\56\x2e\56\x2e\x2e\x2e\x2e\56\x2e\56\x2e");
        $this->twofautility->customlog("\120\154\x75\x67\x69\156\72\x20\x4d\x61\x67\x65\x6e\164\x6f\x20\x76\145\162\163\151\157\x6e\40\x3a\40" . $this->twofautility->get_magento_version() . "\40\x3b\40\x50\x68\160\40\166\x65\162\163\x69\157\156\x3a\40" . phpversion());
        $this->twofautility->customlog("\103\x75\x73\164\x6f\155\x65\x72\x5f\145\155\141\x69\154\x3a\x20" . $QCWeY);
        $this->twofautility->customlog("\56\x2e\x2e\56\x2e\x2e\56\56\x2e\56\x2e\56\56\56\56\56\56\x2e\56\56\x2e\56\x2e\x2e\56\56\56\56\56\x2e\x2e\56\56\56\56\56\56\x2e\56\x2e\56\x2e\x2e\56\x2e\x2e\56\x2e\56\x2e\56\56\56\x2e\56\56\x2e\x2e\x2e\56\x2e\56\x2e\56\56\x2e\x2e\56\x2e\56");
    }
    public function create_log_file($IYqPp, $em0DV)
    {
        return $this->fileFactory->create($IYqPp, $em0DV, DirectoryList::VAR_DIR);
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_SUPPORT);
    }
}