<?php

namespace App\Event;

use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;

class NotificationListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'Model.Post.afterSave' => 'onPostSaved',
        ];
    }

    public function onPostSaved(EventInterface $event, $entity, $options): void
    {
        if ($entity->isNew()) {
            // Lógica para un artículo nuevo
            \Cake\Log\Log::write('error', 'Un nuevo artículo ha sido guardado: ' . $entity->title);
        } else {
            // Lógica para un artículo actualizado
            \Cake\Log\Log::write('error', 'Un artículo ha sido actualizado: ' . $entity->title);
        }
    }
}
