<?php

namespace Journalctl\Channels;

/**
 * Class FirebaseMessage
 * @package Journalctl\Channels
 */
class FirebaseMessage
{
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';

    /**
     * @var string|array
     */
    private $to;
    /**
     * @var array
     */
    private $notification   = [];
    /**
     * @var array
     */
    private $data;
    /**
     * @var string normal|high
     */
    private $priority = self::PRIORITY_NORMAL;

    /**
     * @var string
     */
    private $condition;

    /**
     * @var string
     */
    private $collapseKey;

    /**
     * @var boolean
     */
    private $contentAvailable;

    /**
     * @var boolean
     */
    private $mutableContent;

    /**
     * @var int
     */
    private $timeToTive;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @param string|array $recipient
     * @param bool $recipientIsTopic
     * @return $this
     */
    public function to($recipient, $recipientIsTopic = false)
    {
        if ($recipientIsTopic && is_string($recipient)) {
            $this->to = '/topics/' . $recipient;
        } else {
            $this->to = $recipient;
        }

        return $this;
    }

    /**
     * @return string|array|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * The FCM notification title.
     * @param string
     * @return $this
     */
    public function title(String $title)
    {
        $this->notification['title'] = $title;

        return $this;
    }

    /**
     * The FCM notification body.
     * @param string
     * @return $this
     */
    public function body(String $body)
    {
        $this->notification['body'] = $body;

        return $this;
    }

    /**
     * The FCM notification sound.
     * @param string
     * @return $this
     */
    public function sound($sound = null)
    {
        if ($sound) {
            $this->notification['sound'] = $sound;
        }

        return $this;
    }

    /**
     * The FCM notification icon.
     * @param string
     * @return $this
     */
    public function icon($icon = null)
    {
        if ($icon) {
            $this->notification['icon'] = $icon;
        }

        return $this;
    }

    /**
     * The FCM notification click action.
     * @param string
     * @return $this
     */
    public function clickAction($action = null)
    {
        if ($action) {
            $this->notification['click_action'] = $action;
        }

        return $this;
    }

    /**
     * @param array|null $data
     * @return $this
     */
    public function data($data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $priority
     * @return $this
     */
    public function priority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     * @return $this
     */
    public function condition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * @param string $collapseKey
     * @return $this
     */
    public function collapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * @param boolean $contentAvailable
     * @return $this
     */
    public function contentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * @param boolean $mutableContent
     * @return $this
     */
    public function mutableContent($mutableContent)
    {
        $this->mutableContent = $mutableContent;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeToTive()
    {
        return $this->timeToTive;
    }

    /**
     * @param int $timeToTive
     * @return $this
     */
    public function timeToTive($timeToTive)
    {
        $this->timeToTive = $timeToTive;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @param string $packageName
     * @return $this
     */
    public function packageName($packageName)
    {
        $this->packageName = $packageName;

        return $this;
    }

    /**
     * @return string
     */
    public function formatData()
    {
        $payload = [
            'priority' => $this->priority,
        ];

        if (is_array($this->to)) {
            $payload['registration_ids'] = $this->to;
        } else {
            $payload['to'] = $this->to;
        }

        if (isset($this->data) && count($this->data)) {
            $payload['data'] = $this->data;
        }

        if (isset($this->notification) && count($this->notification)) {
            $payload['notification'] = $this->notification;
        }

        if (isset($this->condition) && !empty($this->condition)) {
            $payload['condition'] = $this->condition;
        }

        if (isset($this->collapseKey) && !empty($this->collapseKey)) {
            $payload['collapse_key'] = $this->collapseKey;
        }

        if (isset($this->contentAvailable)) {
            $payload['content_available'] = $this->contentAvailable;
        }

        if (isset($this->mutableContent)) {
            $payload['mutable_content'] = $this->mutableContent;
        }

        if (isset($this->timeToTive)) {
            $payload['time_to_live'] = $this->timeToTive;
        }

        if (isset($this->packageName) && !empty($this->packageName)) {
            $payload['restricted_package_name'] = $this->packageName;
        }

        return \GuzzleHttp\json_encode($payload);
    }
}
