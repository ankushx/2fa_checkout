<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Settings2fa;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Response\Http\FileFactory;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
use MiniOrange\TwoFA\Helper\TwoFAUtility;
class Index extends BaseAdminAction implements HttpPostActionInterface, HttpGetActionInterface
{
    protected $fileFactory;
    public function __construct(Context $VBF_1, TwoFAUtility $vfhLx, \Magento\Framework\View\Result\PageFactory $Pd3Q1, \Magento\Framework\Message\ManagerInterface $HRT3y, \Psr\Log\LoggerInterface $MiasQ, FileFactory $Ymwsm)
    {
        parent::__construct($VBF_1, $Pd3Q1, $vfhLx, $HRT3y, $MiasQ);
        $this->fileFactory = $Ymwsm;
    }
    public function execute()
    {
        try {
            $WC7jX = $this->getRequest()->getParams();
            $HkQar = $this->twofautility->getCurrentAdminUser()->getEmail();
            $this->twofautility->isFirstPageVisit($HkQar, "\62\x46\x41\x20\x53\145\x74\164\151\156\147\x73");
            if (!$this->isFormOptionBeingSaved($WC7jX)) {
                goto yZmE6;
            }
            $this->processValuesAndSaveData($WC7jX);
            $this->twofautility->flushCache();
            $this->messageManager->addSuccessMessage(TwoFAMessages::SETTINGS_SAVED);
            $this->twofautility->reinitConfig();
            yZmE6:
        } catch (\Exception $zX7ez) {
            $this->messageManager->addErrorMessage($zX7ez->getMessage());
            $this->logger->debug($zX7ez->getMessage());
        }
        $aq6b0 = $this->resultPageFactory->create();
        $aq6b0->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $aq6b0;
    }
    protected function processValuesAndSaveData($WC7jX)
    {
        if (!(isset($WC7jX["\x6f\160\x74\x69\x6f\156"]) && $WC7jX["\157\160\164\151\x6f\x6e"] === "\x73\x61\166\145\x53\x69\x6e\147\111\156\123\x65\x74\164\x69\x6e\147\163\137\x63\x75\163\x74\157\155\145\x72")) {
            goto iVzBt;
        }
        if (!isset($WC7jX["\x72\x75\x6c\145\163"])) {
            goto s_4d7;
        }
        $lGYMX = json_decode($WC7jX["\162\x75\x6c\145\163"], true);
        foreach ($lGYMX as &$neTvQ) {
            $neTvQ["\163\x69\x74\145"] = preg_replace("\57\x5c\x6e\x2f", '', trim($neTvQ["\x73\x69\164\145"]));
            $neTvQ["\x67\x72\157\x75\160"] = preg_replace("\57\x5c\156\x2f", '', trim($neTvQ["\x67\162\x6f\x75\160"]));
            rxoEy:
        }
        Rve_O:
        unset($neTvQ);
        $this->twofautility->setGlobalConfig(TwoFAConstants::CURRENT_CUSTOMER_RULE, json_encode($lGYMX));
        s_4d7:
        iVzBt:
    }
}