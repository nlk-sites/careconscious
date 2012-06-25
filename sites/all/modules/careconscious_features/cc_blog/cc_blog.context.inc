<?php

/**
 * Implementation of hook_context_default_contexts().
 */
function cc_blog_context_default_contexts() {
  $export = array();

  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'blog_sidebars';
  $context->description = '';
  $context->tag = '';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'blog' => 'blog',
        'blog/*' => 'blog/*',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'block-51' => array(
          'module' => 'block',
          'delta' => 51,
          'region' => 'right',
          'weight' => 0,
        ),
        'views-blog_categories-block_1' => array(
          'module' => 'views',
          'delta' => 'blog_categories-block_1',
          'region' => 'right',
          'weight' => 1,
        ),
        'views-recent_blogs-block_1' => array(
          'module' => 'views',
          'delta' => 'recent_blogs-block_1',
          'region' => 'right',
          'weight' => 2,
        ),
        'follow-site' => array(
          'module' => 'follow',
          'delta' => 'site',
          'region' => 'right',
          'weight' => 3,
        ),
      ),
    ),
    'theme' => array(
      'title' => '',
      'subtitle' => '',
      'class' => 'ccblog',
    ),
  );
  $context->condition_mode = 0;
  $export['blog_sidebars'] = $context;

  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'global';
  $context->description = 'global layout including header and footer';
  $context->tag = 'global';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        '~dashboard' => '~dashboard',
        '~dashboard/*' => '~dashboard/*',
        '~users/*' => '~users/*',
        '~user' => '~user',
        '~user/*' => '~user/*',
      ),
    ),
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'nice_menus-1' => array(
          'module' => 'nice_menus',
          'delta' => 1,
          'region' => 'header',
          'weight' => 0,
        ),
        'block-33' => array(
          'module' => 'block',
          'delta' => 33,
          'region' => 'header',
          'weight' => 1,
        ),
        'block-14' => array(
          'module' => 'block',
          'delta' => 14,
          'region' => 'prefooter',
          'weight' => 0,
        ),
        'block-15' => array(
          'module' => 'block',
          'delta' => 15,
          'region' => 'prefooter',
          'weight' => 1,
        ),
        'block-16' => array(
          'module' => 'block',
          'delta' => 16,
          'region' => 'prefooter',
          'weight' => 2,
        ),
        'block-17' => array(
          'module' => 'block',
          'delta' => 17,
          'region' => 'footer',
          'weight' => 0,
        ),
        'views-recent_blogs-block_2' => array(
          'module' => 'views',
          'delta' => 'recent_blogs-block_2',
          'region' => 'footer',
          'weight' => 1,
        ),
        'multiblock-1' => array(
          'module' => 'multiblock',
          'delta' => 1,
          'region' => 'footer',
          'weight' => 2,
        ),
        'menu-secondary-links' => array(
          'module' => 'menu',
          'delta' => 'secondary-links',
          'region' => 'footer',
          'weight' => 3,
        ),
        'block-5' => array(
          'module' => 'block',
          'delta' => 5,
          'region' => 'footer',
          'weight' => 4,
        ),
        'follow-site' => array(
          'module' => 'follow',
          'delta' => 'site',
          'region' => 'footer',
          'weight' => 5,
        ),
      ),
    ),
    'theme' => array(
      'title' => '',
      'subtitle' => '',
      'class' => 'not-dashboard',
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('global');
  t('global layout including header and footer');
  $export['global'] = $context;

  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'global-loggedin';
  $context->description = 'for authenticated users';
  $context->tag = 'global';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        '~dashboard' => '~dashboard',
        '~dashboard/*' => '~dashboard/*',
        '~blog' => '~blog',
        '~blog/*' => '~blog/*',
      ),
    ),
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
    'user' => array(
      'values' => array(
        'authenticated user' => 'authenticated user',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'block-32' => array(
          'module' => 'block',
          'delta' => 32,
          'region' => 'right',
          'weight' => 0,
        ),
      ),
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('for authenticated users');
  t('global');
  $export['global-loggedin'] = $context;

  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'global-loggedout';
  $context->description = 'for anonymous users';
  $context->tag = 'global';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        '~dashboard' => '~dashboard',
        '~dashboard/*' => '~dashboard/*',
        '~blog' => '~blog',
        '~blog/*' => '~blog/*',
      ),
    ),
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
    'user' => array(
      'values' => array(
        'anonymous user' => 'anonymous user',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'quicktabs-register_login' => array(
          'module' => 'quicktabs',
          'delta' => 'register_login',
          'region' => 'right',
          'weight' => 0,
        ),
      ),
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('for anonymous users');
  t('global');
  $export['global-loggedout'] = $context;

  $context = new stdClass;
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'global_user_register';
  $context->description = 'global layout including header and footer, for /user/register';
  $context->tag = 'global';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'user/register' => 'user/register',
      ),
    ),
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'nice_menus-1' => array(
          'module' => 'nice_menus',
          'delta' => 1,
          'region' => 'header',
          'weight' => 0,
        ),
        'block-33' => array(
          'module' => 'block',
          'delta' => 33,
          'region' => 'header',
          'weight' => 1,
        ),
        'block-14' => array(
          'module' => 'block',
          'delta' => 14,
          'region' => 'prefooter',
          'weight' => 0,
        ),
        'block-15' => array(
          'module' => 'block',
          'delta' => 15,
          'region' => 'prefooter',
          'weight' => 1,
        ),
        'block-16' => array(
          'module' => 'block',
          'delta' => 16,
          'region' => 'prefooter',
          'weight' => 2,
        ),
        'block-17' => array(
          'module' => 'block',
          'delta' => 17,
          'region' => 'footer',
          'weight' => 0,
        ),
        'views-blog-block_1' => array(
          'module' => 'views',
          'delta' => 'blog-block_1',
          'region' => 'footer',
          'weight' => 1,
        ),
        'multiblock-1' => array(
          'module' => 'multiblock',
          'delta' => 1,
          'region' => 'footer',
          'weight' => 2,
        ),
        'menu-secondary-links' => array(
          'module' => 'menu',
          'delta' => 'secondary-links',
          'region' => 'footer',
          'weight' => 3,
        ),
        'block-5' => array(
          'module' => 'block',
          'delta' => 5,
          'region' => 'footer',
          'weight' => 4,
        ),
        'follow-site' => array(
          'module' => 'follow',
          'delta' => 'site',
          'region' => 'footer',
          'weight' => 5,
        ),
      ),
    ),
    'theme' => array(
      'title' => '',
      'subtitle' => '',
      'class' => 'not-dashboard',
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('global');
  t('global layout including header and footer, for /user/register');
  $export['global_user_register'] = $context;

  return $export;
}
