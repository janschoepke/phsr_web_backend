<?php
/**
 * Created by PhpStorm.
 * User: janschopke
 * Date: 04.06.17
 * Time: 20:35
 */
namespace src\services;

use DB\Base\GroupQuery;
use DB\Base\GroupVictimsQuery;
use DB\Base\UserGroupsQuery;
use DB\Base\UserVictimsQuery;
use DB\Base\VictimQuery;
use DB\UserQuery;
use DB\Group;
use DB\Victim;

class VictimService {
    function addGroup($userMail, $name, $description) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $victimGroup = new Group();
            $victimGroup->setName($name);
            $victimGroup->setDescription($description);

            $currentUser->addGroup($victimGroup);
            $currentUser->save();
            return true;
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function getUserGroups($userMail, $raw = false) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $userGroups = GroupQuery::create()->filterByUser($currentUser)->find();
            if (!$raw) {
                return $userGroups->toJSON();
            }
            return $userGroups;
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function editGroup($userMail, $groupID, $name, $description) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentGroup = GroupQuery::create()->filterById($groupID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentGroup)) {
                $currentGroup->setName($name);
                $currentGroup->setDescription($description);
                $currentGroup->save();
                return true;
            } else {
                throw new \ApplicationException("There is no group with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function getGroup($userMail, $groupID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentGroup = GroupQuery::create()->filterById($groupID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentGroup)) {
                return $currentGroup->toJSON();
            } else {
                throw new \ApplicationException("There is no group with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function deleteGroup($userMail, $groupID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentGroup = GroupQuery::create()->filterById($groupID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentGroup)) {
                $groupSubscriptions = UserGroupsQuery::create()->filterByGroupId($currentGroup->getId());
                if($groupSubscriptions->count() > 0) {
                    foreach ($groupSubscriptions as $groupSubscription) {
                        $groupSubscription->delete();
                    }
                }
                $currentGroup->delete();
                return true;
            } else {
                throw new \ApplicationException("There is no group with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function addVictim($userMail, $name, $lastName, $email, $description, $birthday, $gender){
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $victim = new Victim();
            $victim->setFirstname($name);
            $victim->setLastname($lastName);
            $victim->setEmail($email);
            $victim->setDescription($description);
            $victim->setBirthday($birthday);
            $victim->setGender(($gender == "male") ? true : false);
            $currentUser->addVictim($victim);
            $currentUser->save();
            return true;
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function addVictimToGroup($userMail, $groupID, $victimID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentGroup = GroupQuery::create()->filterById($groupID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentGroup)) {
                $currentVictim = VictimQuery::create()->filterById($victimID)->filterByUser($currentUser)->findOne();
                if(!is_null($currentVictim)) {
                    $currentGroup->addVictim($currentVictim);
                    $currentGroup->save();
                    return true;
                } else {
                    throw new \ApplicationException("There is no victim with this id.");
                    return false;
                }
            } else {
                throw new \ApplicationException("There is no group with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function getGroupVictims($userMail, $groupID, $raw = false) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentGroup = GroupQuery::create()->filterById($groupID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentGroup)) {
                $groupVictims = VictimQuery::create()->filterByGroup($currentGroup)->find();
                if(!$raw) {
                    return $groupVictims->toJSON();
                }
                return $groupVictims->toArray();
            } else {
                throw new \ApplicationException("There is no group with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function getAllVictims($userMail) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $allVictims = VictimQuery::create()->filterByUser($currentUser)->find();
            return $allVictims->toJSON();
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function getVictim($userMail, $victimID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentVictim = VictimQuery::create()->filterById($victimID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentVictim)) {
                return $currentVictim->toJSON();
            } else {
                throw new \ApplicationException("There is no victim with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function editVictim($userMail, $victimID, $name, $lastName, $email, $description, $birthday, $gender) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentVictim = VictimQuery::create()->filterById($victimID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentVictim)) {
                $currentVictim->setFirstname($name);
                $currentVictim->setLastname($lastName);
                $currentVictim->setEmail($email);
                $currentVictim->setDescription($description);
                $currentVictim->setBirthday($birthday);
                $currentVictim->setGender(($gender == "male") ? true : false);
                $currentVictim->save();
                return true;
            } else {
                throw new \ApplicationException("There is no victim with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function removeVictimFromGroup($userMail, $groupID, $victimID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentGroup = GroupQuery::create()->filterById($groupID)->filterByUser($currentUser)->findOne();
            if(!is_null($currentGroup)) {
                $currentVictim = VictimQuery::create()->filterById($victimID)->filterByUser($currentUser)->findOne();
                if(!is_null($currentVictim)) {
                    $subscriptions = GroupVictimsQuery::create()->filterByGroup($currentGroup)->filterByVictim($currentVictim)->find();
                    if($subscriptions->count() > 0) {
                        foreach ($subscriptions as $subscription) {
                            $subscription->delete();
                        }
                        return true;
                    } else {
                        throw new \ApplicationException("There is no victim with this id in the given group.");
                        return false;
                    }
                } else {
                    throw new \ApplicationException("There is no victim with this id.");
                    return false;
                }
            } else {
                throw new \ApplicationException("There is no group with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }

    function deleteVictim($userMail, $victimID) {
        $currentUser = UserQuery::create()->filterByEmail($userMail)->findOne();
        if(!is_null($currentUser)) {
            $currentVictim = VictimQuery::create()->filterByUser($currentUser)->filterById($victimID)->findOne();
            if(!is_null($currentVictim)) {
                $subscribedGroups = GroupVictimsQuery::create()->filterByVictim($currentVictim)->find();
                foreach ($subscribedGroups as $subscribedGroup) {
                    $subscribedGroup->delete();
                }
                $subscribedUsers = UserVictimsQuery::create()->filterByVictim($currentVictim)->find();
                foreach($subscribedUsers as $subscribedUser) {
                    $subscribedUser->delete();
                }
                $currentVictim->delete();
                return true;
            } else {
                throw new \ApplicationException("There is no victim with this id.");
                return false;
            }
        } else {
            throw new \ApplicationException("There is no such email address.");
            return false;
        }
    }
}
