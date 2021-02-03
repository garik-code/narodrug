<?php
class Sabai_Addon_DirectoryMyCRED extends Sabai_Addon
{    
    const VERSION = '1.4.9', PACKAGE = 'sabai-directory';
    
    public function isUninstallable($currentVersion)
    {
        return true;
    }
    
    public function isInstallable()
    {
        return $this->_application->isAddonLoaded('Directory') && $this->_application->isAddonLoaded('MyCRED');
    }
    
    public function onMyCREDHooksFilter(&$hooks)
    {
        if (!isset($hooks['Directory'])) {
            $hooks['Directory'] = array(
                'actions' => array(),
                'references' => array(), 
            );
        }
        $hooks['Directory']['actions'] += array(
            'listing_created' => array(
                'hook' => 'entity_create_content_directory_listing_entity_success',
                'num_args' => 3,
            ),
            'listing_published' => array(
                'hook' => 'content_post_published',
                'num_args' => 1,
            ),
            'review_created' => array(
                'hook' => 'entity_create_content_directory_listing_review_entity_success',
                'num_args' => 3,
            ),
            'review_published' => array(
                'hook' => 'content_post_published',
                'num_args' => 1,
            ),
            'listing_claimed' => array(
                'hook' => 'directory_listing_claim_status_change',
                'num_args' => 1,
            ),
            'listing_voted_rating' => array(
                'hook' => 'voting_content_directory_listing_entity_voted_rating',
                'num_args' => 2,
            ),
            'review_voted_helpful' => array(
                'hook' => 'voting_content_directory_listing_review_entity_voted_helpful',
                'num_args' => 2,
            ),
            'photo_voted_helpful' => array(
                'hook' => 'voting_content_directory_listing_photo_entity_voted_helpful',
                'num_args' => 2,
            ),
        );
        $hooks['Directory']['references'] += array(
            'submit_listing' => array(
                'label' => _x('Submit listing', 'MyCRED log', 'sabai-directory'),
            ),
            'submit_review' => array(
                'label' => _x('Submit review', 'MyCRED log', 'sabai-directory'),
            ),
            'claim_listing' => array(
                'label' => _x('Claim listing', 'MyCRED log', 'sabai-directory'),
            ),
            'listing_rated5' => array(
                'label' => sprintf(_x('Listing rated %d stars or up', 'MyCRED log', 'sabai-directory'), 5),
                'default_credits' => 3,
            ),
            'listing_rated4' => array(
                'label' => sprintf(_x('Listing rated %d stars or up', 'MyCRED log', 'sabai-directory'), 4),
                'default_credits' => 2,
            ),
            'listing_rated3' => array(
                'label' => sprintf(_x('Listing rated %d stars or up', 'MyCRED log', 'sabai-directory'), 3),
                'default_credits' => 1,
            ),
            'vote_review' => array(
                'label' => _x('Voting review helpful', 'MyCRED log', 'sabai-directory'),
            ),
            'vote_down_review' => array(
                'label' => _x('Voting review unhelpful', 'MyCRED log', 'sabai-directory'),
                'default_credits' => -1,
            ),
            'unvote_review' => array(
                'label' => _x('Unvoting review', 'MyCRED log', 'sabai-directory'),
                'default_credits' => -1,
            ),
            'review_voted' => array(
                'label' => _x('Review voted helpful', 'MyCRED log', 'sabai-directory'),
            ),
            'review_voted_down' => array(
                'label' => _x('Review voted unhelpful', 'MyCRED log', 'sabai-directory'),
                'default_credits' => -1,
            ),
            'vote_photo' => array(
                'label' => _x('Voting photo helpful', 'MyCRED log', 'sabai-directory'),
            ),
            'vote_down_photo' => array(
                'label' => _x('Voting photo unhelpful', 'MyCRED log', 'sabai-directory'),
                'default_credits' => -1,
            ),
            'unvote_photo' => array(
                'label' => _x('Unvoting photo', 'MyCRED log', 'sabai-directory'),
                'default_credits' => -1,
            ),
            'photo_voted' => array(
                'label' => _x('Photo voted helpful', 'MyCRED log', 'sabai-directory'),
            ),
            'photo_voted_down' => array(
                'label' => _x('Photo voted unhelpful', 'MyCRED log', 'sabai-directory'),
                'default_credits' => -1,
            ),
        );
    }
    
    public function onMyCREDHookDirectory($hook, $action, $args)
    {        
        $this->_application->DirectoryMyCRED_Hook($hook, $action, $args);
    }
}
