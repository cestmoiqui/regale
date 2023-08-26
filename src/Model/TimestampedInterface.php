<?php

namespace App\Model;

interface TimestampedInterface
{

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt): self;

    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(\DateTimeInterface $modifiedAt): self;
}

// The getCreatedAt method must return the date and time at which the entity was created. The return type is either null, or an instance of DateTimeInterface.
// The setCreatedAt takes a DateTimeInterface as argument and must set it in the entity's createdAt property. It must also return the instance of the entity itself (self), which enables the chaining of methods.
// Same for UpdatedAt but to update it.