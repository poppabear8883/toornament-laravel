<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Webhook;
use ServNX\Toornament\Models\Subscription;

class WebhookService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'webhooks';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'webhooks';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:admin';

    /**
     * Get all webhooks.
     *
     * @return array
     */
    public function all(): array
    {
        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 50, [], $this->getScope());

        return array_map(function ($item) {
            return new Webhook($item);
        }, $data);
    }

    /**
     * Get a specific webhook.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Webhook
     */
    public function find(string $id): Webhook
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Webhook($data);
    }

    /**
     * Create a new webhook.
     *
     * @param string $name
     * @param string $url
     * @param bool $enabled
     * @return \ServNX\Toornament\Models\Webhook
     */
    public function create(string $name, string $url, bool $enabled = true): Webhook
    {
        $data = [
            'name' => $name,
            'url' => $url,
            'enabled' => $enabled
        ];

        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            $this->getScope()
        );

        return new Webhook($response);
    }

    /**
     * Update a webhook.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\Webhook
     */
    public function update(string $id, array $data): Webhook
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new Webhook($response);
    }

    /**
     * Delete a webhook.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $this->client()->request('DELETE', "{$this->endpoint}/{$id}", [], $this->getScope());

        return true;
    }

    /**
     * Get all subscriptions for a webhook.
     *
     * @param string $webhookId
     * @return array
     */
    public function subscriptions(string $webhookId): array
    {
        $data = $this->client()->paginate(
            'GET',
            "{$this->endpoint}/{$webhookId}/subscriptions",
            'subscriptions',
            50,
            [],
            $this->getScope()
        );

        return array_map(function ($item) {
            return new Subscription($item);
        }, $data);
    }

    /**
     * Get a specific subscription.
     *
     * @param string $webhookId
     * @param string $subscriptionId
     * @return \ServNX\Toornament\Models\Subscription
     */
    public function findSubscription(string $webhookId, string $subscriptionId): Subscription
    {
        $data = $this->client()->request(
            'GET',
            "{$this->endpoint}/{$webhookId}/subscriptions/{$subscriptionId}",
            [],
            $this->getScope()
        );

        return new Subscription($data);
    }

    /**
     * Create a new subscription.
     *
     * @param string $webhookId
     * @param string $eventName
     * @param string $scope
     * @param string $scopeId
     * @return \ServNX\Toornament\Models\Subscription
     */
    public function createSubscription(string $webhookId, string $eventName, string $scope, string|null $scopeId): Subscription
    {
        $data = [
            'event_name' => $eventName,
            'scope' => $scope,
            'scope_id' => $scopeId
        ];

        $response = $this->client()->request(
            'POST',
            "{$this->endpoint}/{$webhookId}/subscriptions",
            ['json' => $data],
            $this->getScope()
        );

        return new Subscription($response);
    }

    /**
     * Update a subscription.
     *
     * @param string $webhookId
     * @param string $subscriptionId
     * @param array $data
     * @return \ServNX\Toornament\Models\Subscription
     */
    public function updateSubscription(string $webhookId, string $subscriptionId, array $data): Subscription
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$webhookId}/subscriptions/{$subscriptionId}",
            ['json' => $data],
            $this->getScope()
        );

        return new Subscription($response);
    }

    /**
     * Delete a subscription.
     *
     * @param string $webhookId
     * @param string $subscriptionId
     * @return bool
     */
    public function deleteSubscription(string $webhookId, string $subscriptionId): bool
    {
        $this->client()->request(
            'DELETE',
            "{$this->endpoint}/{$webhookId}/subscriptions/{$subscriptionId}",
            [],
            $this->getScope()
        );

        return true;
    }
}