<style>
    .nav-sub{
        background: #334257!important;
    }
</style>

<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                @php($restaurant_logo=\App\Models\BusinessSetting::where(['key'=>'logo'])->first()->value)
                <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="Front">
                    <img class="navbar-brand-logo" style="max-height: 55px; border-radius: 8px;max-width: 100%!important;"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('storage/app/public/business/'.$restaurant_logo)}}"
                         alt="Logo">
                    <img class="navbar-brand-logo-mini" style="max-height: 55px; border-radius: 8px;max-width: 100%!important;"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('storage/app/public/business/'.$restaurant_logo)}}" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Content -->
            <div class="navbar-vertical-content" style="background-color: #334257;">
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('admin')?'show':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="{{route('admin.dashboard')}}" title="{{__('messages.dashboard')}}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{__('messages.dashboard')}}
                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->
                   <!-- Attendance-->

                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('messages.report_and_analytics')}}">{{__('messages.report_and_analytics')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        
                    @if(\App\CentralLogics\Helpers::module_permission_check('custom_role'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/day-wise-report')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.report.day-wise-report')}}"
                               title="{{__('messages.attendance')}} {{__('messages.report')}}">
                                <span class="tio-report nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.attendance')}} {{__('messages.report')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/day-wise-report')?'active':''}}">
                            <a class="nav-link " href="/admin/employee/temp-entries-view"
                               title="{{__('messages.attendance')}} {{__('messages.report')}}">
                                <span class="tio-city nav-icon"></span>
                                <span
                                    class="text-truncate"> {{__('messages.live_report')}}</span>
                            </a>
                        </li>

                        
                    @endif

                    
                <!-- End attendance -->
                   <!-- Employee-->

                   <li class="nav-item">
                        <small class="nav-subtitle"
                               title="{{__('messages.employee_handle')}}">{{__('messages.employee')}} {{__('section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::module_permission_check('custom_role'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/custom-role*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.custom-role.create')}}"
                               title="{{__('messages.employee')}} {{__('messages.Role')}}">
                                <i class="tio-incognito nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.employee')}} {{__('messages.Role')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(\App\CentralLogics\Helpers::module_permission_check('employee'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/employee*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:"
                               title="{{__('messages.Employee')}}">
                                <i class="tio-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.employees')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/employee*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/employee/add-new')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.employee.add-new')}}"
                                       title="{{__('messages.add')}} {{__('messages.new')}} {{__('messages.Employee')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{__('messages.add')}} {{__('messages.new')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/employee/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.employee.list')}}"
                                       title="{{__('messages.Employee')}} {{__('messages.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.list')}}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                @endif
                <!-- End Employee -->

                  
                   
                  

                 

                    <!-- Business Settings -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('messages.business')}} {{__('messages.settings')}}">{{__('messages.business')}} {{__('messages.settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/business-setup')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.business-setup')}}"
                               title="{{__('messages.business')}} {{__('messages.setup')}}"
                            >
                                <span class="tio-settings nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.business')}} {{__('messages.setup')}}</span>
                            </a>
                        </li>

                        @if(\App\CentralLogics\Helpers::module_permission_check('zone'))
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/zone*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.zone.home')}}" title="{{__('messages.zone')}}">
                                <i class="tio-city nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{__('messages.delivery_zone')}}                                
                                </span>
                            </a>
                        </li>
                        

                       
                    @endif
                   
                    <!-- End Restaurant -->


               
                      
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/mail-config')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.mail-config')}}"
                               title="{{__('messages.mail')}} {{__('messages.config')}}"
                            >
                                <span class="tio-email nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.mail')}} {{__('messages.config')}}</span>
                            </a>
                        </li>
                      
                    @endif
                <!-- End Business Settings -->

                    <!-- web & adpp Settings -->
                    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{__('messages.business')}} {{__('messages.settings')}}">{{__('messages.web_and_app')}} {{__('messages.settings')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/app-settings*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.app-settings')}}"
                               title="{{__('messages.app_settings')}}"
                            >
                                <span class="tio-android nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.app_settings')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/config*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.config-setup')}}"
                               title="{{__('messages.third_party_apis')}}"
                            >
                                <span class="tio-key nav-icon"></span>
                                <span
                                    class="text-truncate">{{__('messages.third_party_apis')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/pages*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:" title="{{__('messages.pages')}} {{__('messages.setup')}}"
                            >
                                <i class="tio-pages nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{__('messages.pages')}} {{__('messages.setup')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('admin/business-settings/pages*')?'block':'none'}}">

                                <li class="nav-item {{Request::is('admin/business-settings/pages/terms-and-conditions')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.terms-and-conditions')}}"
                                       title="{{__('messages.terms_and_condition')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.terms_and_condition')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/business-settings/pages/privacy-policy')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.privacy-policy')}}"
                                       title="{{__('messages.privacy_policy')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.privacy_policy')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/business-settings/pages/about-us')?'active':''}}">
                                    <a class="nav-link "
                                       href="{{route('admin.business-settings.about-us')}}"
                                       title="{{__('messages.about_us')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{__('messages.about_us')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/file-manager*')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.file-manager.index')}}"
                               title="{{__('messages.third_party_apis')}}"
                            >
                                <span class="tio-album nav-icon"></span>
                                <span
                                    class="text-truncate text-capitalize">{{__('messages.gallery')}}</span>
                            </a>
                        </li>
                    @endif
                <!-- End web & adpp Settings -->


              


                    <li class="nav-item" style="padding-top: 100px">

                    </li>
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>
