<?php

return [
    'property' => 'Property',
    'for' => [
        'sell' => 'Sell',
        'rent' => 'Rent',
        'sell_property_title' => ':name for Sell',
        'rent_property_title' => ':name for Rent',
        'both_property_title' => ':name for Sell/Rent',
        'neither_property_title' => ':name not for Sell/Rent',
    ],
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'blocked' => 'Blocked',
        'draft' => 'Draft',
        'review' => 'Admin Review',
    ],
    'rent_price_type' => [
        'yearly' => 'Yearly',
        'monthly' => 'Monthly',
    ],
    'viewing_schedule_option' => [
        'weekdays' => 'Weekdays',
        'weekend' => 'Weekend',
        'viewable_weekdays_text' => 'This property is only viewable on Weekdays',
        'viewable_weekend_text' => 'This property is only viewable on Weekend',
    ],
    'parking' => [
        'garage' => 'Garage',
        'private' => 'Private Parking',
        'street' => 'Street Parking',
    ],
    'furnishing' => [
        'furnished' => 'Furnished',
        'part_furnished' => 'Semi Furnished',
        'unfurnished' => 'Unfurnished',
    ],
    'certificate' => [
        'strata_title' => 'Strata Title',
        'hgb' => 'Hak Guna Bangunan',
        'hm' => 'Hak Milik',
        'ppjb' => 'PPJB',
        'hpl' => 'HPL'
    ],
    'create' => [
        'page_title' => 'Main Details',
        'body_copy' => 'Tell us all about your property.',
        'list_detail_section_title' => 'Listing Details',
        'list_detail_section_copy' => 'Please fill in the details below, about the property you area advertising on GoProp',
        'preview_property' => 'Preview Property',
        'disable_property' => 'Disable Property',
    ],
    'main_details' => [
        'page_title' => 'More information about <span>:title<span>',
        'page_subtitle' => 'Description about your property',
        'body_copy' => 'Complete all the fields below that relates to your property. These additional details will make it easier for people to find your property.',
        'short_description_hint' => 'Insert key features of your property in a few lines.',
        'virtual_tour_hint' => 'Virtual tours and videos of your home can make all the difference. Add your virtual tour by entering your unique URL in the field below. You can also add Youtube videos here.'
    ],
    'map' => [
        'page_title' => 'Map of <span>:title<span>',
        'body_copy' => 'If the marker is not placed in the right location of your property, simply drag the map so the marker is pointing to the correct location.',
        'search_map' => 'Search map',
        'point_map_question' => 'Select property location on Google Map'
    ],
    'photos' => [
        'page_title' => 'Photos of <span>:title<span>',
        'body_copy' => '<p>Photos makes your property look more attractive to buyers and showcase the best things about your property. You can add photos up to maximum 50 photos. You can also edit, delete, or re-order the photos at any time.</p>
						<p>If you have selected professional photography service you can skip this section and come back to this when you have your property ready.</p>',
        'upload_photos_title' => 'Upload photos(landscape only)',
        'upload_photos_hint' => 'You can upload multiple photos it one go. You can upload up to 15 images (Max: 5MB)',
        'choose_photos' => 'Choose Photos',
        'uploaded_photos_title' => 'Uploaded Photos',
        'before_title' => 'Standard Photo',
        'after_title' => 'Professional Photography'
    ],
    'floorplans' => [
        'page_title' => 'Floorplans of <span>:title<span>',
        'body_copy' => 'A floorplan shows an overview of your property layouts. If you already have one, you can upload it as an image. If you don\'t have one, we can create it for you later.',
        'upload_photos_title' => 'Upload floorplan images',
        'upload_photos_hint' => 'You can upload up to 5 floorplans (Max: 2MB)',
        'choose_floorplans' => 'Choose Floorplans',
        'uploaded_floorplans_title' => 'Uploaded Floorplans'
    ],
    'packages' => [
        'page_title' => 'Select a package for <span>:title<span>',
        'body_copy' => 'Please select from one of the packages below. Please note that your property will need to be verified before it goes live so this may take a few days. We will contact you soon about the verification process.',
    ],
    'packages_edit' => [
        'page_title' => 'Current package for <span>:title<span>',
        'body_copy' => 'To update your Property package, please contact us.',
    ],
    'property_type' => [
        'residential' => 'Residential',
        'house' => 'House',
        'apartment' => 'Apartment',
        'shophouse' => 'Shophouse (Ruko)',
        'commercial' => 'Commercial',
        'factory' => 'Factory',
        'land' => 'Land',
        'villa' => 'Villa',
        'warehouse' => 'Warehouse',
        'working-space' => 'Working Space / Office Space',
    ],
    'orientation' => [
        'north' => 'North',
        'north_east' => 'North East',
        'east' => 'East',
        'south_east' => 'South East',
        'south' => 'South',
        'south_west' => 'South West',
        'west' => 'West',
        'north_west' => 'North West',
    ],
    'messages' => [
        'save_successful' => 'Your information is successfully saved.',
        'attachment_invalid_property' => 'The photo is invalid.',
        'photo_delete_successful' => 'Photo is successfully removed.',
        'floorplan_delete_successful' => 'Floorplan is successfully removed.',
        'photo_rotate_successful' => 'Photo is successfully rotated.',
        'unpublished' => 'Property is successfully unpublished.',
        'published' => 'Property is successfully published.',
        'publish_failed' => 'Property can\'t be published due to unauthorized action.',
        'unauthorized_access' => 'You are not authorized to access this page.'
    ],
    'steps' => [
        'main_details' => 'Main Details',
        'property_details' => 'Property Details',
        'map' => 'Map',
        'photos' => 'Photos',
        'floorplan' => 'Floorplan',
        'packages' => 'Packages',
    ],
    'package' => [
        'sign_up_btn' => 'Sign Up',
        'submit_btn' => 'Select',
        'min_fee' => 'min fee IDR. 5,000,000',
        'save_calculation' => 'property value x 2.5% (other traditional commission agent) - (property value x go prop fee) + upfront cost',
        'category' => [
            'sell' => 'Sell My Property',
            'rent' => 'Rent My Property',
            'sell_label' => 'Sell',
            'rent_label' => 'Rent',
        ],
        'sell_package' => 'Choose Sell Package',
        'rent_package' => 'Choose Rent Package',
        'feature' => [
            'value' => 'Property value',
            'projection-fee' => 'Projection fee after completion',
            'you-can-save' => 'You can save',
            'up-front-fees' => 'Pay up-front fees',
            'sell-fee' => 'Our fee: Only pay when your property is sold',
            'sell-fee-notes' => '* Above / Below (3,000,000,000)',
            'rent-fee' => 'Our fee: Only pay when your property is rent',
            'rent-fee-notes' => '',
            'property-verification' => 'Property verification visit by GoProp agent',
            'exclusive-agency-contract' => 'Exclusive agency contract with a 4 month tie-in',
            'legal-setup' => 'Legal setup',
            'full-sales-progression' => 'Full sales progression',
            'viewing-management' => 'Viewing Management',
            'viewing-feedback' => 'Viewing Feedback',
            'offer-negotiation' => 'Offer Negotiation',
            'senior-agent' => 'Handle by Senior Agent',
            'internal-advertising' => 'Advertised on our homepage',
            'search-rank-priority' => 'Priority on our search results',
            'property-consultation' => 'Property consultation with GoProp Agent',
            'major-property-advertising' => 'Advertised on major property portals',
            'major-property-advertising-advanced' => 'Advertised on major property portals with advanced features',
            'for-sale-board' => 'For sale board',
            'professional-floor-plan' => 'Professional floor plan',
            'professional-photography' => 'Professional photography',
            'professional-virtual-tour' => 'Professional virtual tour',
            'for-rent-board' => 'For rent board',
        ]
    ],
    'order_review' => [
        'page_title' => 'Order Review',
        'your_package' => 'Your package',
        'addons' => 'Your addons',
        'total_cost' => 'Total Cost',
        'upfront_fee' => 'Upfront Fee',
        'agent_commission' => 'Agent Commission upon completion',
        'payment_methods' => 'Payment Methods',
        'agree_tc' => 'I agree to the',
        'terms_conditions' => 'terms & conditions',
        'confirm_message' => 'Do you want to submit this order?'
    ],
    'success' => [
        'page_title' => 'Your property is successfully submitted!',
        'body_copy' => 'Thank you for trusting GoProp to be your partner. Don\'t worry, your property is in good hands. Please sit back and relax, we will contact you as soon as possible for verification process and further information. If you have any questions, please contact us at :phone or :email.'
    ],
    'index' => [
        'property_search' => 'Property Search',
        'im_looking_for' => 'Property for',
        'title' => 'Property',
        'price_range' => 'Price range',
        'for_sell_title' => 'Property for sale',
        'for_rent_title' => 'Property for rent',
        'for_all_title' => 'Property for sell/rent',
        'search_filter' => 'Search Filter',
        'in_city' => 'in <strong>:location</strong>',
        'advanced_search' => 'Advanced Search (:count)',
        'submit_property' => 'Submit Property',
        'search_property' => 'Search Property',
        'bedrooms' => '[0,1] Bedroom|[2,Inf] Bedrooms',
        'bathrooms' => '[0,1] Bathroom|[2,Inf] Bathrooms',
        'type_keyword' => 'Type Keyword',
        'sort_by' => [
            'price_asc' => 'Lowest Price',
            'price_desc' => 'Highest Price',
            'date_desc' => 'Newest',
            'date_asc' => 'Oldest',
        ]
    ],
    'view' => [
        'details' => 'Details',
        'floorplans' => 'Floor Plans',
        'address' => 'Address',
        'set_draft_edit' => 'Unpublish and Edit Property',
        'preview_edit' => 'Edit Property',
        'preview_text' => 'Preview Mode',
        'virtual_tour' => 'Virtual Tour',
        'unpublish_confirm' => 'This action will unpublish the property. Are you sure you want to do this?',
        'in_city' => 'in :location',
    ],
    'like' => [
        'like_message' => 'You just liked :property_name.',
        'unlike_message' => ':property_name is removed from your interest list.',
        'please_login' => 'Please login to like property.',
        'own_property' => 'You can\'t like your own property.',
    ],
    'advanced_search_widget' => [
        'advanced_search' => 'Advanced Search'
    ],
    'price_saving_widget' => [
        'estimated_property_price' => 'Your Estimated Property Sale Price',
        'adjust_price' => 'Adjust the slider to match your property value',
        'you_save' => 'You can save',
        'terms' => 'When you sell your property with GoProp.<br/>Based on traditional agent commission of 2.5%.',
        'other_agent_term' => 'When you sell your property with traditional property agent',
        'other_agent_commission' => 'Other Agents Commission',
        'calculate_btn' => 'Calculate!',
        'or' => 'OR'

    ],
    'exclusive_property_widget' => [
        'title' => 'Exclusive Property',
    ],
    'featured_property_widget' => [
        'title' => 'Featured Property',
    ],
    'my_properties' => [
        'property_i_sell' => 'Property I Sell',
        'property_i_lease' => 'Property I Lease',
        'property_interested' => 'Property I\'m Interested In',
        'more_results' => 'More Results'
    ],
    'schedule_viewing' => [
        'title' => 'Schedule a Viewing',
        'schedule_btn' => 'Schedule',
        'label' => 'Viewing Time',
        'time' => [
            'afternoon' => 'Afternoon',
            'morning' => 'Morning',
        ],
        'legends' => [
            'today' => 'Today',
            'scheduled_viewing' => 'View of my property',
            'property_i_view' => 'Properties I\'m viewing',
        ],
        'success_message' => 'We have received your Booking request. Our agent will contact you.',
        'reschedule_success_message' => 'We have received your reschedule request. Our agent will contact you.'
    ],
    'property_comparison' => [
        'compare_properties' => 'Compare Properties',
        'title' => 'Compare Listings',
        'add_message' => ':name is added to comparison.',
        'remove_message' => ':name is removed from comparison.',
        'compare_btn' => 'Compare',
        'tooltip_compare' => 'Add to Comparison',
        'tooltip_uncompare' => 'Remove from Comparison',
    ],
    'inbox' => [
        'title' => 'Inbox',
        'your_properties' => 'Your Properties',
        'send_message' => 'Send',
        'properties_interested' => 'Properties you\'re interested in',
        'please_select_property' => 'Please select a property above first.',
        'please_add_message' => 'No message. Please add a message to start a conversation with our agent.',
        'conversation_started' => 'Conversation started :time',
        'no_result_message' => 'You haven\'t shown any interest in a property yet.<br />Search for property you\'re interested in to see it here.',
        'sent_message' => 'Your message is successfully sent to our agent.',
        'property_questions' => 'Property Questions',
    ],
    'viewings' => [
        'title' => 'Viewing Calendars',
        'view_of_my_property' => 'View of my property',
        'properties_i_view' => 'Properties I\'m viewing',
        'scheduled_label' => 'Viewing scheduled',
        'change_date' => 'Change date',
    ],
    'buttons' => [
        'talk_to_agent' => 'Talk to Our Agent',
        'schedule_viewing' => 'Schedule Viewing',
        'new_property' => 'Upload New Property',
        'edit_property' => 'Edit Property',
        'like' => 'Like',
        'unlike' => 'Unlike',
        'disable' => 'Disable property',
        'preview' => 'Preview property',
        'enable' => 'Enable property',
    ]
];