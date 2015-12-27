<?php

namespace GoProp\Http\Middleware;

use Closure;
use Menu;

class MenuMiddleware
{
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

                    $menu->raw('<h2 class="sidebar-header">Master</h2>');
                    $menu->add('Members', ['route' => ['admin.member.index']])->prepend('<i class="fa fa-user"></i> ');
                    $menu->add('Agents', ['route' => ['admin.agent.index']])->prepend('<i class="fa fa-users"></i> ');

                    $menu->raw('<h2 class="sidebar-header">Operations</h2>');
                    $menu->add('Viewing Schedules', ['route' => ['admin.viewing_schedule.index']])->prepend('<i class="fa fa-calendar"></i> ');
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