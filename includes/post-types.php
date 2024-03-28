<?php
class newPostType
{
    public $name;
    public $singular_name;
    public $icon;
    public $supports;
    public $rewrite;
    public $show_in_rest = false;
    public $exclude_from_search = false;
    public $publicly_queryable = true;
    public $show_in_admin_bar = true;
    public $has_archive = true;
    public $hierarchical = false;
    public $text_domain = 'coptrz';


    function __construct()
    {

        add_action('init', array($this, 'create_post_type'));
    }


    function create_post_type()
    {
        register_post_type(
            strtolower($this->name),
            array(
                'labels'              => array(
                    'name'               => _x($this->name, 'post type general name', $this->text_domain),
                    'singular_name'      => _x($this->singular_name, 'post type singular name', $this->text_domain),
                    'menu_name'          => _x($this->name, 'admin menu'), $this->text_domain,
                    'name_admin_bar'     => _x($this->singular_name, 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Add New', strtolower($this->name), $this->text_domain),
                    'add_new_item'       => __('Add New ' . $this->singular_name, $this->text_domain),
                    'new_item'           => __('New ' . $this->singular_name, $this->text_domain),
                    'edit_item'          => __('Edit ' . $this->singular_name, $this->text_domain),
                    'view_item'          => __('View ' . $this->singular_name, $this->text_domain),
                    'all_items'          => __('All ' . $this->name, $this->text_domain),
                    'search_items'       => __('Search ' . $this->name, $this->text_domain),
                    'parent_item_colon'  => __('Parent :' . $this->name, $this->text_domain),
                    'not_found'          => __('No ' . strtolower($this->name) . ' found.', $this->text_domain),
                    'not_found_in_trash' => __('No ' . strtolower($this->name) . ' found in Trash.', $this->text_domain)
                ),
                'show_in_rest'        => $this->show_in_rest,
                'supports'            => $this->supports,
                'public'              => true,
                'has_archive'         => $this->has_archive,
                'hierarchical'        => $this->hierarchical,
                'rewrite'             => $this->rewrite,
                'menu_icon'           => $this->icon,
                'capability_type'     => 'page',
                'exclude_from_search' => $this->exclude_from_search,
                'publicly_queryable'  => $this->publicly_queryable,
                'show_in_admin_bar'   => $this->show_in_admin_bar,
            )
        );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Taxonomy
/*-----------------------------------------------------------------------------------*/
class newTaxonomy
{
    public $taxonomy;
    public $post_type;
    public $args;

    function __construct()
    {
        add_action('init', array($this, 'create_taxonomy'));
        add_action('restrict_manage_posts', array($this, 'filter_by_taxonomy'), 10, 2);
        add_filter('manage_' . $this->post_type . '_posts_columns', array($this, 'change_table_column_titles'));
        add_filter('manage_' . $this->post_type . '_posts_custom_column', array($this, 'change_column_rows'), 10, 2);
        add_filter('manage_edit-' . $this->post_type . '_sortable_columns', array($this, 'change_sortable_columns'));
    }

    function create_taxonomy()
    {
        register_taxonomy($this->taxonomy, $this->post_type, $this->args);
    }

    function filter_by_taxonomy($post_type, $which)
    {
        // Apply this only on a specific post type
        if ($this->post_type !== $post_type)
            return;

        // A list of taxonomy slugs to filter by
        $taxonomies = array($this->taxonomy);

        foreach ($taxonomies as $taxonomy_slug) {

            // Retrieve taxonomy data
            $taxonomy_obj = get_taxonomy($taxonomy_slug);
            $taxonomy_name = $taxonomy_obj->labels->name;

            // Retrieve taxonomy terms
            $terms = get_terms($taxonomy_slug);

            // Display filter HTML
            echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
            echo '<option value="">' . sprintf(esc_html__('Show All %s', 'text_domain'), $taxonomy_name) . '</option>';
            foreach ($terms as $term) {
                printf(
                    '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                    $term->slug,
                    ((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
                    $term->name,
                    $term->count
                );
            }
            echo '</select>';
        }
    }
    function change_table_column_titles($columns)
    {
        unset($columns['date']); // temporarily remove, to have custom column before date column
        $columns[$this->taxonomy] = $this->args['label'];
        $columns['date'] = 'Date'; // readd the date column
        return $columns;
    }

    function change_column_rows($column_name, $post_id)
    {
        if ($column_name == $this->taxonomy) {
            echo get_the_term_list($post_id, $this->taxonomy, '', ', ', '') . PHP_EOL;
        }
    }

    function change_sortable_columns($columns)
    {
        $columns[$this->taxonomy] = $this->taxonomy;
        return $columns;
    }
}


$FAQs = new newPostType();
$FAQs->name = 'FAQ';
$FAQs->singular_name = 'FAQ';
$FAQs->icon = 'dashicons-info';
$FAQs->supports = array('title', 'revisions', 'editor');
$FAQs->exclude_from_search = true;
$FAQs->publicly_queryable = false;
$FAQs->show_in_admin_bar = false;
$FAQs->has_archive = false;

$FAQs_Category = new newTaxonomy();
$FAQs_Category->taxonomy = 'faq_cat';
$FAQs_Category->post_type = 'faq';
$FAQs_Category->args = array(
    'label'        => 'FAQs Categories',
    'labels' => array(
        'name'                       => _x('FAQs Categories', 'Taxonomy General Name', 'text_domain'),
        'singular_name'              => _x('FAQs Category', 'Taxonomy Singular Name', 'text_domain'),
        'menu_name'                  => __('FAQs Category', 'text_domain'),
        'all_items'                  => __('All Items', 'text_domain'),
        'parent_item'                => __('Parent Item', 'text_domain'),
        'parent_item_colon'          => __('Parent Item:', 'text_domain'),
        'new_item_name'              => __('New Item Name', 'text_domain'),
        'add_new_item'               => __('Add New Item', 'text_domain'),
        'edit_item'                  => __('Edit Item', 'text_domain'),
        'update_item'                => __('Update Item', 'text_domain'),
        'view_item'                  => __('View Item', 'text_domain'),
        'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
        'add_or_remove_items'        => __('Add or remove items', 'text_domain'),
        'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
        'popular_items'              => __('Popular Items', 'text_domain'),
        'search_items'               => __('Search Items', 'text_domain'),
        'not_found'                  => __('Not Found', 'text_domain'),
        'no_terms'                   => __('No items', 'text_domain'),
        'items_list'                 => __('Items list', 'text_domain'),
        'items_list_navigation'      => __('Items list navigation', 'text_domain'),
    ),
    'hierarchical' => true,
    'query_var'    => true,
    'rewrite'      => array(
        'slug'         => 'FAQs-category',
    )
);
