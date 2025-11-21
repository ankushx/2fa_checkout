<?php

namespace MiniOrange\TwoFA\Controller\Actions;

use MiniOrange\TwoFA\Helper\Curl;
use MiniOrange\TwoFA\Helper\Exception\AccountAlreadyExistsException;
use MiniOrange\TwoFA\Helper\Exception\PasswordMismatchException;
use MiniOrange\TwoFA\Helper\Exception\TransactionLimitExceededException;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
use MiniOrange\TwoFA\Helper\TwoFAMessages;
class RegisterNewUserAction extends BaseAdminAction
{
    private $REQUEST;
    private $loginExistingUserAction;
    public function __construct(\Magento\Backend\App\Action\Context $jcLK9, \Magento\Framework\View\Result\PageFactory $U8B9K, \MiniOrange\TwoFA\Helper\TwoFAUtility $sMICQ, \Magento\Framework\Message\ManagerInterface $skiT3, \Psr\Log\LoggerInterface $P8fFs, \MiniOrange\TwoFA\Controller\Actions\LoginExistingUserAction $RV3tT)
    {
        parent::__construct($jcLK9, $U8B9K, $sMICQ, $skiT3, $P8fFs);
        $this->loginExistingUserAction = $RV3tT;
    }
    public function execute()
    {
        if (isset($this->REQUEST["\x72\145\147\151\163\164\145\162\145\x64"])) {
            goto ZbVQ0;
        }
        $this->checkIfRequiredFieldsEmpty(["\x65\x6d\141\x69\154" => $this->REQUEST, "\160\x61\163\x73\167\157\x72\144" => $this->REQUEST, "\x63\157\x6e\x66\151\162\155\120\141\x73\x73\x77\157\162\x64" => $this->REQUEST]);
        goto g3piv;
        ZbVQ0:
        $this->checkIfRequiredFieldsEmpty(["\x65\x6d\141\x69\x6c" => $this->REQUEST, "\160\141\163\x73\167\x6f\x72\x64" => $this->REQUEST]);
        g3piv:
        $vALVU = $this->REQUEST["\x65\x6d\x61\151\x6c"];
        $YQAMJ = $this->REQUEST["\x70\141\163\163\167\157\162\x64"];
        $NY7QK = $this->REQUEST["\143\x6f\x6e\x66\151\162\x6d\x50\x61\163\163\167\x6f\x72\144"];
        $K4PZW = $this->REQUEST["\x63\157\155\x70\141\156\x79\116\x61\155\x65"];
        $SCiQT = $this->REQUEST["\146\151\x72\163\x74\116\141\155\145"];
        $a3mbb = $this->REQUEST["\154\x61\163\164\116\x61\x6d\145"];
        if (isset($this->REQUEST["\162\x65\x67\151\163\164\x65\x72\x65\144"])) {
            goto Y3r_s;
        }
        if (!(strcasecmp($NY7QK, $YQAMJ) != 0)) {
            goto xGEv7;
        }
        throw new PasswordMismatchException();
        xGEv7:
        Y3r_s:
        $this->twofautility->setStoreConfig(TwoFAConstants::CUSTOMER_EMAIL, $vALVU);
        $this->loginExistingUserAction->setRequestParam($this->REQUEST)->execute();
        return;
    }
    private function configureUserInMagento($t6ld5, $bm2Qp)
    {
        $this->logger->debug("\111\156\40\143\x6f\156\146\151\x67\165\162\x65\125\x73\145\x72\111\x6e\x4d\141\147\145\x6e\164\157\50\51");
        $this->twofautility->setStoreConfig(TwoFAConstants::SAMLSP_KEY, $t6ld5["\151\144"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::API_KEY, $t6ld5["\141\x70\151\x4b\145\171"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::TOKEN, $t6ld5["\164\157\153\x65\x6e"]);
        $this->twofautility->setStoreConfig(TwoFAConstants::REG_STATUS, TwoFAConstants::STATUS_COMPLETE_LOGIN);
        $this->getMessageManager()->addSuccessMessage(TwoFAMessages::REG_SUCCESS);
    }
    public function setRequestParam($Hkx7w)
    {
        $this->REQUEST = $Hkx7w;
        return $this;
    }
}