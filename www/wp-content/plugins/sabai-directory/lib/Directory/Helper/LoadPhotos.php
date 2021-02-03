<?php
class Sabai_Addon_Directory_Helper_LoadPhotos extends Sabai_Helper
{    
    public function help(Sabai $application, array $entities, $bundleType = 'directory_listing')
    {
        if ($bundleType === 'directory_listing') {
            if ($entities = $this->_filterEntitiesToLoad($entities)) {
                $photos = $application->Entity_Query('content')
                    ->propertyIs('post_entity_bundle_type', 'directory_listing_photo')
                    ->propertyIs('post_status', 'published')
                    ->fieldIsIn('content_parent', array_keys($entities))
                    ->fieldIsNotNull('directory_photo', 'official') // official photos
                    ->sortByField('directory_photo', 'ASC', 'display_order')
                    ->fetch();
                foreach ($photos as $photo) {
                    if (($listing = $photo->getSingleFieldValue('content_parent'))
                        && is_object($entities[$listing->getId()])
                    ) {
                        $entities[$listing->getId()]->addFieldValue('directory_photos', $photo);
                    }
                }
            }
        } elseif ($bundleType === 'directory_listing_review') {
            if ($entities = $this->_filterEntitiesToLoad($entities)) {
                $photos = $application->Entity_Query('content')
                    ->propertyIs('post_entity_bundle_type', 'directory_listing_photo')
                    ->propertyIs('post_status', 'published')
                    ->fieldIsIn('content_reference', array_keys($entities))
                    ->sortByProperty('post_id', 'ASC')
                    ->fetch();
                foreach ($photos as $photo) {
                    if (($review = $photo->getSingleFieldValue('content_reference'))
                        && is_object($entities[$review->getId()])
                    ) {
                        $entities[$review->getId()]->addFieldValue('directory_photos', $photo);
                    }
                }
            }
        }
    }
    
    protected function _filterEntitiesToLoad(array $entities)
    {
        foreach (array_keys($entities) as $entity_id) {
            if (null !== $entities[$entity_id]->getFieldValue('directory_photos')) {
                unset($entities[$entity_id]);
            } else {
                $entities[$entity_id]->setFieldValue('directory_photos', array());
            }
        }
        return $entities;
    }
}