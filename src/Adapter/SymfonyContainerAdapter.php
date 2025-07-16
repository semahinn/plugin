<?php

namespace Snr\Plugin\Adapter;

use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;

class SymfonyContainerAdapter extends ContainerAdapter implements SymfonyContainerInterface {

  public function __construct(SymfonyContainerInterface $real_container) {
    parent::__construct($real_container);
  }

  /**
   * @return SymfonyContainerInterface
   */
  public function getRealContainer() {
    return $this->realContainer;
  }

  /**
   * {@inheritdoc}
   */
  public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE) {
    return $this->realContainer->get($id, $invalidBehavior);
  }

  /**
   * {@inheritdoc}
   */
  public function has($id): bool {
    return $this->realContainer->has($id);
  }

  /**
   * {@inheritdoc}
   */
  public function set($id, $service) {
    return $this->realContainer->set($id, $service);
  }

  /**
   * {@inheritdoc}
   */
  public function initialized($id) {
    return $this->realContainer->initialized($id);
  }

  /**
   * {@inheritdoc}
   */
  public function getParameter($name) {
    return $this->realContainer->getParameter($name);
  }

  /**
   * {@inheritdoc}
   */
  public function hasParameter($name) {
    return $this->realContainer->hasParameter($name);
  }

  /**
   * {@inheritdoc}
   */
  public function setParameter($name, $value) {
    return $this->realContainer->setParameter($name, $value);
  }

}