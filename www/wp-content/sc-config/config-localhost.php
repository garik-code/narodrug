<?php 
defined( 'ABSPATH' ) || exit;
return array (
  'enable_page_caching' => true,
  'advanced_mode' => false,
  'enable_in_memory_object_caching' => false,
  'enable_gzip_compression' => false,
  'in_memory_cache' => 'memcached',
  'page_cache_length' => 24,
  'page_cache_length_unit' => 'hours',
  'cache_exception_urls' => '',
  'enable_url_exemption_regex' => false,
); 
