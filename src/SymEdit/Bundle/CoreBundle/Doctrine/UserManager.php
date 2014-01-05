<?php

namespace SymEdit\Bundle\CoreBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use SymEdit\Bundle\CoreBundle\Model\UserManagerInterface;

class UserManager extends BaseUserManager implements UserManagerInterface
{
    protected $profileClass;
    protected $adminProfileClass;

    public function setProfileClass($profileClass)
    {
        $this->profileClass = $profileClass;
    }

    public function setAdminProfileClass($adminProfileClass)
    {
        $this->adminProfileClass = $adminProfileClass;
    }

    public function createProfile($admin = false)
    {
        $profileClass = $admin ? $this->adminProfileClass : $this->profileClass;

        $profile = new $profileClass();

        return $profile;
    }

    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\UserInterface
     */
    public function createUser($admin = false)
    {
        $user = parent::createUser();
        $user->setProfile($this->createProfile($admin));
        $user->setAdmin($admin);

        $role = $admin ? 'ROLE_ADMIN' : 'ROLE_USER';
        $user->addRole($role);

        return $user;
    }

    public function findProfileBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->profileClass)->findOneBy($criteria);
    }

    public function findProfilesBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->profileClass)->findBy($criteria);
    }

    public function findAdminProfileBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->adminProfileClass)->findOneBy($criteria);
    }

    public function findAdminProfilesBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->adminProfileClass)->findBy($criteria);
    }

    public function findAdmins()
    {
        return $this->repository->findBy(array('admin' => true));
    }

    public function findAdminBy(array $criteria)
    {
        $criteria['admin'] = true;

        return $this->findUserBy($criteria);
    }
}