<?php

namespace App\Entity;

use App\Repository\EventRepository;
use App\Security\CreatorAwareInterface;
use App\Security\OrganizationAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups as SerializeGroups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event implements CreatorAwareInterface, OrganizationAwareInterface
{
    #[SerializeGroups('Volunteer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[SerializeGroups('Volunteer')]
    #[Assert\NotNull()]
    #[Assert\Length(min: 10)]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotNull()]
    #[Assert\Length(min: 30)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?bool $accessible = null;

    #[Assert\Length(min: 20)]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prerequisites = null;

    #[Assert\NotNull()]
    #[Assert\GreaterThanOrEqual('today')]
    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[Assert\NotNull()]
    #[Assert\GreaterThanOrEqual(propertyPath: 'startAt')]
    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    /**
     * @var Collection<int, Volunteer>
     */
    #[ORM\OneToMany(targetEntity: Volunteer::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $volunteers;

    /**
     * @var Collection<int, Organization>
     */
    #[Assert\Count(min: 1)]
    #[ORM\ManyToMany(targetEntity: Organization::class, inversedBy: 'events')]
    private Collection $organizations;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $createdBy = null;

    public function __construct()
    {
        $this->volunteers = new ArrayCollection();
        $this->organizations = new ArrayCollection();
    }

    public function isNew(): bool
    {
        return null === $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isAccessible(): ?bool
    {
        return $this->accessible;
    }

    public function setAccessible(bool $accessible): static
    {
        $this->accessible = $accessible;

        return $this;
    }

    public function getPrerequisites(): ?string
    {
        return $this->prerequisites;
    }

    public function setPrerequisites(?string $prerequisites): static
    {
        $this->prerequisites = $prerequisites;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable|null $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable|null $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection<int, Volunteer>
     */
    public function getVolunteers(): Collection
    {
        return $this->volunteers;
    }

    public function addVolunteer(Volunteer $volunteer): static
    {
        if (!$this->volunteers->contains($volunteer)) {
            $this->volunteers->add($volunteer);
            $volunteer->setEvent($this);
        }

        return $this;
    }

    public function removeVolunteer(Volunteer $volunteer): static
    {
        if ($this->volunteers->removeElement($volunteer)) {
            // set the owning side to null (unless already changed)
            if ($volunteer->getEvent() === $this) {
                $volunteer->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): static
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): static
    {
        $this->organizations->removeElement($organization);

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
