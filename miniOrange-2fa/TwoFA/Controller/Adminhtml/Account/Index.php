<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Account;

use Magento\Backend\App\Action\Context;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
class Index extends BaseAdminAction
{
    private $options = array("\x72\145\x67\x69\163\x74\145\162\x4e\145\167\125\x73\x65\x72", "\154\x6f\147\x69\156\105\x78\x69\163\164\151\156\x67\x55\163\x65\x72", "\x72\145\x6d\x6f\166\x65\x41\x63\x63\157\x75\x6e\164", "\163\x6b\151\160\x41\x6e\x64\x53\x74\141\x72\x74\124\x72\151\x61\x6c", "\x76\x65\162\151\x66\x79\114\x69\143\145\156\x73\145\113\145\171", "\145\170\x74\145\x6e\144\124\x72\151\x61\x6c", "\141\x63\x74\x69\x76\141\x74\145\x50\x72\x65\155\151\x75\155\x50\x6c\x61\x6e");
    private $registerNewUserAction;
    private $loginExistingUserAction;
    private $lkAction;
    public function __construct(\Magento\Backend\App\Action\Context $MAiL8, \Magento\Framework\View\Result\PageFactory $NDlNh, \MiniOrange\TwoFA\Helper\TwoFAUtility $NRgMz, \Magento\Framework\Message\ManagerInterface $C0xDn, \Psr\Log\LoggerInterface $G1bBb, \MiniOrange\TwoFA\Controller\Actions\LKAction $RB2VO, \MiniOrange\TwoFA\Controller\Actions\RegisterNewUserAction $Xpguw, \MiniOrange\TwoFA\Controller\Actions\LoginExistingUserAction $UxfG_)
    {
        parent::__construct($MAiL8, $NDlNh, $NRgMz, $C0xDn, $G1bBb);
        $this->registerNewUserAction = $Xpguw;
        $this->loginExistingUserAction = $UxfG_;
        $this->lkAction = $RB2VO;
    }
    public function execute()
    {
        try {
            $ruTos = $this->getRequest()->getParams();
            $wKQm2 = $this->twofautility->getCurrentAdminUser()->getEmail();
            $this->twofautility->isFirstPageVisit($wKQm2, "\x41\143\x63\157\165\x6e\164");
            if (!$this->isFormOptionBeingSaved($ruTos)) {
                goto g37Ox;
            }
            $WCMGv = array_values($ruTos);
            $xy1Mr = array_intersect($WCMGv, $this->options);
            if (!(count($xy1Mr) > 0)) {
                goto cmRTW;
            }
            $this->_route_data(array_values($xy1Mr)[0], $ruTos);
            $this->twofautility->flushCache();
            cmRTW:
            $this->twofautility->reinitConfig();
            g37Ox:
        } catch (\Exception $QUV6V) {
            $this->messageManager->addErrorMessage($QUV6V->getMessage());
            $this->logger->debug($QUV6V->getMessage());
        }
        $V1Clf = $this->resultPageFactory->create();
        $V1Clf->setActiveMenu(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_BASE);
        $V1Clf->addBreadcrumb(__("\x41\143\x63\x6f\165\x6e\164\40\123\145\164\164\x69\x6e\147\163"), __("\101\x63\x63\x6f\165\x6e\x74\40\x53\145\164\x74\x69\156\147\x73"));
        $V1Clf->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $V1Clf;
    }
    private function _route_data($xtk1q, $ruTos)
    {
        switch ($xtk1q) {
            case $this->options[0]:
                $this->registerNewUserAction->setRequestParam($ruTos)->execute();
                goto zVcTC;
            case $this->options[1]:
                $this->loginExistingUserAction->setRequestParam($ruTos)->execute();
                goto zVcTC;
            case $this->options[2]:
                $this->lkAction->setRequestParam($ruTos)->removeAccount();
                goto zVcTC;
            case $this->options[3]:
                $this->lkAction->setRequestParam($ruTos)->skipAndStartTrial();
                goto zVcTC;
            case $this->options[4]:
                $this->lkAction->setRequestParam($ruTos)->execute();
                goto zVcTC;
            case $this->options[5]:
                $this->lkAction->setRequestParam($ruTos)->extendTrial();
                goto zVcTC;
            case $this->options[6]:
                $this->lkAction->setRequestParam($ruTos)->activatePremiumPlan();
                goto zVcTC;
        }
        NUK2y:
        zVcTC:
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_ACCOUNT);
    }
    private function goBackToRegistrationPage()
    {
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_EMAIL, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_KEY, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::API_KEY, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::INVOKE_INLINE_REGISTERATION, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::TOKEN, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_PHONE, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::REG_STATUS, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::TXT_ID, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::MODULE_TFA, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::LK_NO_OF_USERS, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::LK_VERIFY, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::KBA_METHOD, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_EMAIL, NULL);
        $this->twofautility->setStoreConfig(TwoFAConstants::ENABLE_CUSTOMGATEWAY_SMS, NULL);
    }
}