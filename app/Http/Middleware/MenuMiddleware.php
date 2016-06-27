<?php

namespace GoProp\Http\Middleware;

use Closure;
use Menu;
use Illuminate\Contracts\Auth\Guard;

class MenuMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeAction = $request->route()->getAction();

        if(is_array($routeAction['middleware'])) {
            if (in_array('admin.auth', $routeAction['middleware'])) {
                Menu::make('adminMenu', function($menu) {
                    $menu->raw('<h2 class="sidebar-header">Welcome</h2>');
                    $menu->add('Dashboard', ['route' => ['admin.dashboard']])->prepend('<i class="fa fa-home"></i> ');

                    if($this->auth->user()->is('administrator')){
                        $menu->raw('<h2 class="sidebar-header">Master</h2>');
                        $menu->add('Members', ['route' => ['admin.member.index']])->prepend('<i class="fa fa-user"></i> ');
                        $menu->add('Agents', ['route' => ['admin.agent.index']])->prepend('<i class="fa fa-users"></i> ');
                        $menu->add('Pages', ['route' => ['admin.page.index']])->prepend('<i class="fa fa-file-o"></i> ');
                        $menu->add('Main Banners', ['route' => ['admin.main_banner.index']])->prepend('<i class="gi gi-picture"></i> ');
                        $menu->add('Testimonials', ['route' => ['admin.testimonial.index']])->prepend('<i class="fa fa-comment"></i> ');
                        $menu->add('Blogs', ['route' => ['admin.post.index']])->prepend('<i class="fa fa-pencil"></i> ')
                            ->link->attr(['class' => 'menu-link']);
                        $menu->blogs->add('Posts', ['route' => ['admin.post.index']]);
                        $menu->blogs->add('Categories', ['route' => ['admin.post.category.index']]);
                        $menu->add('Areas', ['route' => ['admin.location.area.index']])->prepend('<i class="gi gi-google_maps"></i> ');
                        //$menu->blogs->add('Tags', ['route' => ['admin.tag.index']]);

                        $menu->raw('<h2 class="sidebar-header">Operations</h2>');
                        $menu->add('Property Listings', ['route' => ['admin.property.index']])->prepend('<i class="gi gi-home"></i> ');
                        $menu->add('Referrals Info', ['route' => ['admin.referrals.index']])->prepend('<i class="fa fa-bell-o"></i> ');
                        $menu->add('Viewing Schedules', ['route' => ['admin.viewing_schedule.index']])->prepend('<i class="fa fa-calendar"></i> ');
                        $menu->add('Owner Inquiry', ['route' => ['admin.customer_inquiry.index', 'type' => 'owner']])->prepend('<i class="fa fa-comments"></i> ');
                        $menu->add('User Inquiry', ['route' => ['admin.customer_inquiry.index', 'type' => 'user']])->prepend('<i class="fa fa-comments"></i> ');
                    }elseif($this->auth->user()->is('agent')){
                        if($this->auth->user()->manage_property){
                            $menu->raw('<h2 class="sidebar-header">Operations</h2>');
                            $menu->add('Property Listings', ['route' => ['admin.property.index']])->prepend('<i class="gi gi-home"></i> ');
                            $menu->add('Viewing Schedules', ['route' => ['agent.viewing_schedule.index']])->prepend('<i class="fa fa-calendar"></i> ');
                            $menu->add('Owner Inquiry', ['route' => ['admin.customer_inquiry.index', 'type' => 'owner']])->prepend('<i class="fa fa-comments"></i> ');
                            $menu->add('User Inquiry', ['route' => ['admin.customer_inquiry.index', 'type' => 'user']])->prepend('<i class="fa fa-comments"></i> ');
                        }else{
                            $menu->raw('<h2 class="sidebar-header">Properties</h2>');
                            $menu->add('Properties I Refer', ['route' => ['admin.property.index.agent', 'type' => 'referral-listing']])->prepend('<i class="gi gi-home"></i> ');
                            $menu->add('Add Referral', ['route' => ['admin.referrals.create']])->prepend('<i class="fa fa-plus"></i> ');
                            $menu->add('My Referrals', ['route' => ['admin.referrals.index']])->prepend('<i class="fa fa-bell-o"></i> ');
                        }
                    }

                    $menu->raw('<h2 class="sidebar-header">Account</h2>');
                    $menu->add('Profile Update', ['route' => ['admin.account.update']])->prepend('<i class="fa fa-user"></i> ');

                    /*
                    $menu->add('Products', ['route' => ['admin.product.index']])->prepend('<i class="gi gi-tags"></i> ');

                    $menu->add('Writers', ['route' => ['admin.writer.index']])->prepend('<i class="fa fa-pencil"></i> ');

                    $menu->add('Clients', ['route' => ['admin.client.index']])->prepend('<i class="fa fa-briefcase"></i> ');

                    $menu->add('Deposit Packages', ['route' => ['admin.deposit.package.index']])->prepend('<i class="gi gi-shopping_cart"></i> ');

                    $menu->raw('<h2 class="sidebar-header">Operations</h2>');
                    $menu->add('Orders', '#')->prepend('<i class="fa fa-book"></i> ')
                        ->link->attr(['class' => 'menu-link']);
                    $menu->orders->add('Pending Orders', ['route' => ['admin.order.index', 'filter' => ['status' => Order::STATUS_PENDING]]]);
                    $menu->orders->add('Active Orders', ['route' => ['admin.order.index', 'filter' => ['status' => Order::STATUS_ACTIVE]]]);
                    $menu->orders->add('Inactive Orders', ['route' => ['admin.order.index', 'filter' => ['status' => Order::STATUS_INACTIVE]]]);

                    $menu->add('Submissions', '#')->prepend('<i class="fa fa-pencil"></i> ')
                        ->link->attr(['class' => 'menu-link']);
                    $menu->submissions->add('Pending Review', ['route' => ['admin.submission.index', 'status' => Submission::STATUS_REVIEW]]);
                    $menu->submissions->add('Submitted', ['route' => ['admin.submission.index', 'status' => Submission::STATUS_SUBMITTED]]);
                    $menu->submissions->add('Approved', ['route' => ['admin.submission.index', 'status' => Submission::STATUS_APPROVED]]);
                    $menu->submissions->add('Completed', ['route' => ['admin.submission.index', 'status' => Submission::STATUS_COMPLETED]]);

                    $menu->add('Writer Revisions', '#')->prepend('<i class="fa fa-pencil"></i> ')
                        ->link->attr(['class' => 'menu-link']);
                    $menu->writerRevisions->add('Pending Revision', ['route' => ['admin.submission.writer_revision.index', 'status' => SubmissionDetail::STATUS_REVIEW]]);

                    $menu->add('Client Revisions', '#')->prepend('<i class="fa fa-comment"></i> ')
                        ->link->attr(['class' => 'menu-link']);
                    $menu->clientRevisions->add('Pending Review', ['route' => ['admin.submission.client_revision.index', 'status' => Comment::STATUS_PENDING]]);

                    $menu->add('Payments', '#')->prepend('<i class="fa fa-money"></i> ')
                        ->link->attr(['class' => 'menu-link']);
                    $menu->payments->add('Order Payments', ['route' => ['admin.order.payments']]);
                    $menu->payments->add('Deposits', ['route' => ['admin.client.deposit.index']]);

                    $menu->add('Writer Payments', '#')->prepend('<i class="fa fa-money"></i> ')
                        ->link->attr(['class' => 'menu-link']);
                    $menu->writerPayments->add('Writer Payments', ['route' => ['admin.writer.payment.index']]);
                    */
                });
            }
        }

        return $next($request);
    }
}