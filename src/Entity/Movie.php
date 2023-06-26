<?php

namespace App\Entity;
use DateTime;



class Movie
{

    private string $title;
    private string $resume;
    private DateTime $released;
    private int $length;
    private ?int $id;

    public function __construct(string $title, string $resume, DateTime $released, int $length, ?int $id = null)
    {
        $this->title = $title;
        $this->resume = $resume;
        $this->released = $released;
        $this->length = $length;
        $this->id = $id;
    }

	

	

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}
	
	/**
	 * @param string $title 
	 * @return self
	 */
	public function setTitle(string $title): self {
		$this->title = $title;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getResume(): string {
		return $this->resume;
	}
	
	/**
	 * @param string $resume 
	 * @return self
	 */
	public function setResume(string $resume): self {
		$this->resume = $resume;
		return $this;
	}
	
	/**
	 * @return DateTime
	 */
	public function getReleased(): DateTime {
		return $this->released;
	}
	
	/**
	 * @param DateTime $released 
	 * @return self
	 */
	public function setReleased(DateTime $released): self {
		$this->released = $released;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getLength(): int {
		return $this->length;
	}
	
	/**
	 * @param int $length 
	 * @return self
	 */
	public function setLength(int $length): self {
		$this->length = $length;
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @param  $id 
	 * @return self
	 */
	public function setId(?int $id): self {
		$this->id = $id;
		return $this;
	}
}