<?php
class Sabai_Addon_DirectoryMyCRED_Helper_Hook extends Sabai_Helper
{
    public function help(Sabai $application, $hook, $action, $args)
    {
        switch ($action) {
            case 'listing_created':
                $listing = $args[1];
                if ((!$author_id = $listing->getAuthorId())
                    || !$listing->isPublished()
                ) return;
                
                // Add credits to listing author
                $hook->addCredits('Directory', 'submit_listing', $listing->getId(), $author_id);
                break;
            case 'listing_published':
                $listing = $args[0];
                if ($listing->getBundleType() !== 'directory_listing'
                    || (!$author_id = $listing->getAuthorId())
                ) return;
                
                // Add credits to listing author
                $hook->addCredits('Directory', 'submit_listing', $listing->getId(), $author_id);
                break;
            case 'review_created':
                $review = $args[1];
                if ((!$author_id = $review->getAuthorId())
                    || !$review->isPublished()
                ) return;
                
                // Add credits to review author
                $hook->addCredits('Directory', 'submit_review', $review->getId(), $author_id);
                break;
            case 'review_published':
                $review = $args[0];
                if ($review->getBundleType() !== 'directory_listing_review'
                    || (!$author_id = $review->getAuthorId())
                ) return;
                
                // Add credits to review author
                $hook->addCredits('Directory', 'submit_review', $review->getId(), $author_id);
                break;
            case 'listing_claimed':
                $claim = $args[0];
                if ($claim->status === 'approved') {
                    // Add credits to listing author
                    $hook->addCredits('Directory', 'claim_listing', $claim->entity_id, $claim->user_id);
                }
                break;
            case 'listing_voted_rating':   
                $user_id = $application->getUser()->id;
                $listing = $args[0];
                $results = $args[1];
                if (isset($results[''])) {
                    $results = $results[''];
                }
                if ($results['prev_value'] !== false // already rated
                    || $results['value'] === false
                    || $results['value'] <= 3
                    || (!$owner_id = $application->Directory_ListingOwner($listing, false))
                    || $owner_id === $user_id // no points for rating own listing
                ) return;

                if ($results['value'] >= 5) {
                    $ref = 'listing_rated5';
                } elseif ($results['value'] >= 4) {
                    $ref = 'listing_rated4';
                } else {
                    $ref = 'listing_rated3';
                }
                $hook->addCredits('Directory', $ref, $listing->getId(), $owner_id);
                break;
            case 'review_voted_helpful':
                $user_id = $application->getUser()->id;
                $review = $args[0];
                $results = $args[1];
                if ($review->getAuthorId() === $user_id) return; // no points for voting own content
                
                if (isset($results[''])) {
                    $results = $results[''];
                }
                // Undoing vote?
                if ($results['prev_value'] !== false) {
                    if ($user_id) {
                        // Add credits to voter
                        $hook->addCredits('Directory', 'unvote_review', $review->getId(), $user_id);
                    }
                    // Deduct credits from author
                    $hook->deductCredits(
                        'Directory',
                        $results['prev_value'] == 1 ? 'review_voted' : 'review_voted_down',
                        $review->getId(),
                        $review->getAuthorId()
                    );
                }
                // Reflect current vote
                if ($results['value'] !== false) {
                    // Add credits to author
                    $hook->addCredits(
                        'Directory',
                        $results['value'] == 1 ? 'review_voted' : 'review_voted_down', 
                        $review->getId(),
                        $review->getAuthorId()
                    );
                    if ($user_id) {
                        // Add credits to voter
                        $hook->addCredits(
                            'Directory',
                            $results['value'] == 1 ? 'vote_review' : 'vote_down_review',
                            $review->getId(),
                            $user_id
                        );
                    }
                }
                break;
            case 'photo_voted_helpful':
                $user_id = $application->getUser()->id;
                $photo = $args[0];
                $results = $args[1];
                if ($photo->getAuthorId() === $user_id) return; // no points for voting own content
                
                if (isset($results[''])) {
                    $results = $results[''];
                }
                // Undoing vote?
                if ($results['prev_value'] !== false) {
                    if ($user_id) {
                        // Add credits to voter
                        $hook->addCredits('Directory', 'unvote_photo', $photo->getId(), $user_id);
                    }
                    // Deduct credits from author
                    $hook->deductCredits(
                        'Directory',
                        $results['prev_value'] == 1 ? 'photo_voted' : 'photo_voted_down',
                        $photo->getId(),
                        $photo->getAuthorId()
                    );
                }
                // Reflect current vote
                if ($results['value'] !== false) {
                    // Add credits to author
                    $hook->addCredits(
                        'Directory',
                        $results['value'] == 1 ? 'photo_voted' : 'photo_voted_down', 
                        $photo->getId(),
                        $photo->getAuthorId()
                    );
                    if ($user_id) {
                        // Add credits to voter
                        $hook->addCredits(
                            'Directory',
                            $results['value'] == 1 ? 'vote_photo' : 'vote_down_photo',
                            $photo->getId(),
                            $user_id
                        );
                    }
                }
                break;
        }
    }
}

