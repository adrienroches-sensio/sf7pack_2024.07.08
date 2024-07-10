<?php

namespace App\Entity;

use App\Repository\VolunteerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use function dump;

#[Assert\GroupSequence(['Volunteer', 'Strict'])]
#[ORM\Entity(repositoryClass: VolunteerRepository::class)]
class Volunteer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[Assert\NotNull()]
    #[Assert\GreaterThanOrEqual(propertyPath: 'startAt')]
    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'volunteers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'volunteers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'volunteers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $forUser = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

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

    public function getForUser(): ?User
    {
        return $this->forUser;
    }

    public function setForUser(?User $forUser): static
    {
        $this->forUser = $forUser;

        return $this;
    }

    #[Assert\Callback(groups: ['Strict'])]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if ($this->getEvent() instanceof Event) {
            $eventStartDate = $this->getEvent()->getStartAt();
            $eventEndDate = $this->getEvent()->getEndAt();

            if ($this->getStartAt()->format('d/m/Y') < $eventStartDate->format('d/m/Y')
                || $this->getStartAt()->format('d/m/Y') > $eventEndDate->format('d/m/Y')
            ) {
                dump($this->getStartAt(), $eventStartDate, $eventEndDate);
                $context->buildViolation("The volunteering start date should be comprised in the event's dates ([{{ startDate }}, {{ endDate }}])")
                    ->setParameter('{{ startDate }}', $eventStartDate->format('d/m/Y'))
                    ->setParameter('{{ endDate }}', $eventEndDate->format('d/m/Y'))
                    ->atPath('startAt')
                    ->addViolation();
            }

            if (
                $this->getEndAt()->format('d/m/Y') < $eventStartDate->format('d/m/Y')
                || $this->getEndAt()->format('d/m/Y') > $eventEndDate->format('d/m/Y')
            ) {
                $context->buildViolation("The volunteering end date should be comprised in the event's dates ([{{ startDate }}, {{ endDate }}])")
                    ->setParameter('{{ startDate }}', $eventStartDate->format('d/m/Y'))
                    ->setParameter('{{ endDate }}', $eventEndDate->format('d/m/Y'))
                    ->atPath('endAt')
                    ->addViolation();
            }
        }

        if (null === $this->getEvent() && null === $this->getProject()) {
            $context->buildViolation("You have to select and event or a project, or both")
                ->atPath('event')
                ->addViolation();
            $context->buildViolation("You have to select and event or a project, or both")
                ->atPath('project')
                ->addViolation();
        }

        if ($this->getEvent() instanceof Event
            && $this->getProject() instanceof Project
            && !$this->getProject()->getEvents()->contains($this->getEvent())
        ) {

            $context->buildViolation("You have to select an event from the chosen project")
                ->atPath('event')
                ->addViolation();
        }
    }
}
