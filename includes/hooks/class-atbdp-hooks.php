<?php

if ( ! class_exists( 'ATBDP_Hooks' ) ) :
    class ATBDP_Hooks {
        /**
         * @var mixed[]
         */
        public $hooks = [];

        public function __construct() {
            $this->hooks =  $this->get_hooks();
            $this->register_hooks( $this->hooks );
        }

        /**
         * Get Action Hooks
         */
        public function get_hooks(): array {
            return [
                'title_update' => [
                    'name'     => 'the_title',
                    'type'     => 'action',
                    'callback' => ATBDP_Title_Update::class,
                    'priority' => 10,
                    'args'     => 2,
                ],
            ];
        }

        /**
         * Register Hooks
         */
        private function register_hooks( array $hooks ): void {
            if ( $hooks === [] ) { return; }

            foreach ( $hooks as $hook ) {
                self::add_hook( $hook );
            }
        }

        /**
         * Add Hook
         */
        public static function add_hook( array $hook = [] ): void {
            if (class_exists($hook['callback']) && method_exists( $hook['callback'], 'run' )) {
                $class_name    = $hook['callback'];
                $callback      = new $class_name();
                $priority      = $hook['priority'] ?? 10;
                $accepted_args = $hook['args'] ?? 1;
                if ( 'action' === $hook['type'] ) {
                    add_action( $hook['name'], [$callback, 'run'], $priority, $accepted_args );
                }
                if ( 'filter' === $hook['type'] ) {
                    add_filter( $hook['name'], [$callback, 'run'], $priority, $accepted_args );
                }
            }
        }
    }
endif;