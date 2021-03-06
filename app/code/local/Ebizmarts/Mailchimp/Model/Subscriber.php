<?php

class Ebizmarts_Mailchimp_Model_Subscriber extends Mage_Newsletter_Model_Subscriber {

    public function subscribe($email, $city = null, $fromWebHooks = null) {

        $isSubscribed = Mage::app()->getRequest()->getParam('is_subscribed');
        $store = Mage::app()->getStore()->getStoreId();
        $helper = Mage::helper('mailchimp');

        //Constant Contact
        $isConstantContact = Mage::getStoreConfig('constantcontact/general/active');
        if ($isConstantContact == 1) {
            Mage::getSingleton('constantcontact/constantcontact')->subscribe($email, $city);
        } //Constant Contact end

        if ($helper->mailChimpEnabled($store)) {

            $this->loadByEmail($email);

            $customerSession = Mage::getSingleton('customer/session');

            if (!$this->getId()) {
                $this->setSubscriberConfirmCode($this->randomSequence());
            }

            $isConfirmNeed = ((bool) $helper->getSubscribeConfig('double_optin', $store) && !$fromWebHooks) ? true : false;

            if (!$this->getId() || $this->getStatus() == self::STATUS_UNSUBSCRIBED || $this->getStatus() == self::STATUS_NOT_ACTIVE) {
                if ($isConfirmNeed) {
                    // if user subscribes own login email - confirmation is not needed
                    $ownerId = Mage::getModel('customer/customer')
                                    ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                                    ->loadByEmail($email)
                                    ->getId();
                    if ($customerSession->isLoggedIn() && $ownerId == $customerSession->getId()) {
                        $this->setStatus(self::STATUS_SUBSCRIBED);
                    } else {
                        $this->setStatus(self::STATUS_NOT_ACTIVE);
                    }
                } else {
                    $this->setStatus(self::STATUS_SUBSCRIBED);
                }
                $this->setSubscriberEmail($email);
                $this->setSubscriberCity($city);
            }

            if ($customerSession->isLoggedIn()) {
                $this->setStoreId($customerSession->getCustomer()->getStoreId());
                $this->setCustomerId($customerSession->getCustomerId());
            } else {
                $this->setStoreId(Mage::app()->getStore()->getId());
                $this->setCustomerId(0);
            }

            $this->setIsStatusChanged(true);

            try {
                $this->save();
                if ($isConfirmNeed) {
                    $this->sendConfirmationRequestEmail();
                } else {
                    $this->sendConfirmationSuccessEmail();
                }

                return $this->getStatus();
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        } else {
            //Subscription without mailChimp
            $this->loadByEmail($email);
            $customerSession = Mage::getSingleton('customer/session');

            if (!$this->getId()) {
                $this->setSubscriberConfirmCode($this->randomSequence());
            }

            $isConfirmNeed = (Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_FLAG) == 1) ? true : false;
            $isOwnSubscribes = false;

            if (!$this->getId() || $this->getStatus() == self::STATUS_UNSUBSCRIBED || $this->getStatus() == self::STATUS_NOT_ACTIVE || $isSubscribed !='') {
                if ($isConfirmNeed === true) {
                    // if user subscribes own login email - confirmation is not needed
                    $ownerId = Mage::getModel('customer/customer')
                                    ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                                    ->loadByEmail($email)
                                    ->getId();
                    $isOwnSubscribes = ($customerSession->isLoggedIn() && $ownerId == $customerSession->getId());
                    if ($isOwnSubscribes == true) {
                        $this->setStatus(self::STATUS_SUBSCRIBED);
                    } else {
                        $this->setStatus(self::STATUS_NOT_ACTIVE);
                    }
                } else {
                    $this->setStatus(self::STATUS_SUBSCRIBED);
                }
                $this->setSubscriberEmail($email);
                $this->setSubscriberCity($city);
            }

            if ($customerSession->isLoggedIn()) {
                $this->setStoreId($customerSession->getCustomer()->getStoreId());
                $this->setCustomerId($customerSession->getCustomerId());
            } else {
                $this->setStoreId(Mage::app()->getStore()->getId());
                $this->setCustomerId(0);
            }

            $this->setIsStatusChanged(true);

            try {
                $this->save();
                if ($isConfirmNeed === true
                        && $isOwnSubscribes === false
                ) {
                    $this->sendConfirmationRequestEmail();
                } else {
                    $this->sendConfirmationSuccessEmail();
                }

                return $this->getStatus();
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    public function quickSubscribe($customer) {

        $this->setSubscriberConfirmCode($this->randomSequence());
        $this->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
        $this->setSubscriberEmail($customer->getEmail());
        $this->setStoreId($customer->getStoreId());
        $this->setCustomerId($customer->getCustomerId());
        $this->setIsStatusChanged(true);

        try {
            $this->save();
            return $this->getStatus();
        } catch (Exception $e) {
            Mage::helper('mailchimp')->addException($e);
        }
    }

    public function sendConfirmationRequestEmail() {

        if (Mage::helper('mailchimp')->checkSendSubscribe()) {
            return parent::sendConfirmationRequestEmail();
        } else {
            return $this;
        }
    }

    public function sendConfirmationSuccessEmail() {

        if (Mage::helper('mailchimp')->checkSendSubscribe()) {
            return parent::sendConfirmationSuccessEmail();
        } else {
            return $this;
        }
    }

    public function sendUnsubscriptionEmail() {

        if (Mage::helper('mailchimp')->checkSendUnsubscribe()) {
            return parent::sendUnsubscriptionEmail();
        } else {
            return $this;
        }
    }

}

?>
