<?php

namespace ServNX\Toornament\Models;

class CustomField
{
    /**
     * The custom field attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new custom field instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the custom field ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the tournament ID.
     *
     * @return string
     */
    public function getTournamentId(): string
    {
        return $this->attributes['tournament_id'];
    }

    /**
     * Get the machine name.
     *
     * @return string
     */
    public function getMachineName(): string
    {
        return $this->attributes['machine_name'];
    }

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->attributes['label'];
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Get the target type.
     *
     * @return string
     */
    public function getTargetType(): string
    {
        return $this->attributes['target_type'];
    }

    /**
     * Get the default value.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->attributes['default_value'];
    }

    /**
     * Get the position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->attributes['position'];
    }

    /**
     * Check if the field is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return (bool) $this->attributes['required'];
    }

    /**
     * Check if the field is public.
     *
     * @return bool
     */
    public function isPublic(): bool
    {
        return (bool) $this->attributes['public'];
    }

    /**
     * Get the field options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return (array) $this->attributes['options'];
    }

    /**
     * Check if this is a player field.
     *
     * @return bool
     */
    public function isPlayerField(): bool
    {
        return $this->getTargetType() === 'player';
    }

    /**
     * Check if this is a team field.
     *
     * @return bool
     */
    public function isTeamField(): bool
    {
        return $this->getTargetType() === 'team';
    }

    /**
     * Check if this is a team player field.
     *
     * @return bool
     */
    public function isTeamPlayerField(): bool
    {
        return $this->getTargetType() === 'team_player';
    }

    /**
     * Get all custom field attributes.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }
}