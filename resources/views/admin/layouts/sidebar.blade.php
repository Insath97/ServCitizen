<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="text-left ml-n3"
                style="text-transform: none; font-size: 1.3rem;">{{ getSettingInfo('site_name') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">SC</a>
        </div>
        <ul class="sidebar-menu">

            @if (getRole() != 'Officer')
                <li class="menu-header">Dashboard</li>
                <li class="{{ setSidebarActive(['admin.dashboard']) }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fire"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            {{-- Request section --}}
            @if (canAccess(['Request Index', 'Request Create', 'Request Update', 'Request Delete']))
                <li class="menu-header">Requests Section</li>
                <li class="dropdown {{ setSidebarActive(['admin.service-request.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Service Tokens</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.service-request.create']) }}">
                            <a class="nav-link" href="{{ route('admin.service-request.create') }}">New Request</a>
                        </li>
                        <li class="{{ setSidebarActive(['admin.service-request.index']) }} }}">
                            <a class="nav-link" href="{{ route('admin.service-request.index') }}">Inquiry Request</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-header">Complaint Section</li>
                <li class="{{ setSidebarActive(['admin.complaint.*']) }}">
                    <a class="nav-link" href="{{ route('admin.complaint.index') }}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Complaints</span>
                    </a>
                </li>
            @endif

            {{-- payment section --}}
            @if (canAccess(['Payment Index']))
                <li class="menu-header">Payment Section</li>
                <li class="{{ setSidebarActive(['admin.payment.*']) }}">
                    <a class="nav-link" href="{{ route('admin.payment.index') }}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Payments</span>
                    </a>
                </li>
            @endif

            {{-- Token Progress --}}
            @if (canAccess(['Token Status Index']))
                <li class="menu-header">Activity Section</li>
                <li class="{{ setSidebarActive(['admin.activity.*']) }}">
                    <a class="nav-link" href="{{ route('admin.activity.index') }}">
                        <i class="fas fa-network-wired"></i>
                        <span>Working in Progress</span>
                    </a>
                </li>
            @endif

            {{-- client section --}}
            @if (canAccess(['Client Index', 'Client Create', 'Client Update', 'Client Delete']))
                <li class="menu-header">Client Section</li>
                <li class="{{ setSidebarActive(['admin.client.*']) }}">
                    <a class="nav-link" href="{{ route('admin.client.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Clients</span>
                    </a>
                </li>
            @endif

            @if (isSuperAdmin())
                <li class="menu-header">Report Section</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-chart-line"></i>
                        <span>Reports</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="javascript:;">Coming Soon</a></li>
                    </ul>
                </li>
            @endif

            {{-- setting section --}}
            @if (canAccess([
                    'Service Index',
                    'Service Create',
                    'Service Update',
                    'Service Delete',
                    'Service Type Index',
                    'Service Type Create',
                    'Service Type Update',
                    'Service Type Delete',
                    'Status Index',
                    'Status Create',
                    'Status Update',
                    'Status Delete',
                    'Branch Index',
                    'Branch Create',
                    'Branch Update',
                    'Branch Delete',
                    'Unit Index',
                    'Unit Create',
                    'Unit Update',
                    'Unit Delete',
                    'Province Index',
                    'Province Create',
                    'Province Update',
                    'Province Delete',
                    'District Index',
                    'District Create',
                    'District Update',
                    'District Delete',
                    'DS Index',
                    'DS Create',
                    'DS Update',
                    'DS Delete',
                    'GN Division Index',
                    'GN Division Create',
                    'GN Division Update',
                    'GN Division Delete',
                    'Permission Index',
                    'Permission Create',
                    'Permission Update',
                    'Permission Delete',
                    'User Role Index',
                    'User Role Create',
                    'User Role Update',
                    'User Role Delete',
                    'System Setting Index',
                ]))
                <li class="menu-header">Setting</li>

                {{-- service section --}}
                @if (canAccess([
                        'Service Index',
                        'Service Create',
                        'Service Update',
                        'Service Delete',
                        'Service Type Index',
                        'Service Type Create',
                        'Service Type Update',
                        'Service Type Delete',
                        'Status Index',
                        'Status Create',
                        'Status Update',
                        'Status Delete',
                    ]))

                    <li
                        class="dropdown {{ setSidebarActive(['admin.services.*', 'admin.sub-service.*', 'admin.service-type.*', 'admin.services-status.*']) }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-list"></i>
                            <span>Services</span></a>
                        <ul class="dropdown-menu">

                            @if (canAccess(['Service Index', 'Service Create', 'Service Update', 'Service Delete']))
                                <li class="{{ setSidebarActive(['admin.services.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.services.index') }}">Service</a>
                                </li>
                            @endif

                            @if (canAccess(['Service Index', 'Service Create', 'Service Update', 'Service Delete']))
                                <li class="{{ setSidebarActive(['admin.sub-service.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.sub-service.index') }}">Sub Service</a>
                                </li>
                            @endif

                            @if (canAccess(['Service Type Index', 'Service Type Create', 'Service Type Update', 'Service Type Delete']))
                                <li class="{{ setSidebarActive(['admin.service-type.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.service-type.index') }}">Service Type</a>
                                </li>
                            @endif

                            @if (canAccess(['Status Index', 'Status Create', 'Status Update', 'Status Delete']))
                                <li class="{{ setSidebarActive(['admin.services-status.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.services-status.index') }}">Status</a>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif

                {{-- branck and division section --}}
                @if (canAccess([
                        'Branch Index',
                        'Branch Create',
                        'Branch Update',
                        'Branch Delete',
                        'Unit Index',
                        'Unit Create',
                        'Unit Update',
                        'Unit Delete',
                    ]))

                    <li class="dropdown {{ setSidebarActive(['admin.branch.*', 'admin.units.*']) }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-code-branch"></i>
                            <span>Branch & Division</span></a>
                        <ul class="dropdown-menu">

                            @if (canAccess(['Branch Index', 'Branch Create', 'Branch Update', 'Branch Delete']))
                                <li class="{{ setSidebarActive(['admin.branch.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.branch.index') }}">Branches</a>
                                </li>
                            @endif

                            @if (canAccess(['Unit Index', 'Unit Create', 'Unit Update', 'Unit Delete']))
                                <li class="{{ setSidebarActive(['admin.units.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.units.index') }}">Units</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- regions sections --}}
                @if (canAccess([
                        'Province Index',
                        'Province Create',
                        'Province Update',
                        'Province Delete',
                        'District Index',
                        'District Create',
                        'District Update',
                        'District Delete',
                        'DS Index',
                        'DS Create',
                        'DS Update',
                        'DS Delete',
                        'GN Division Index',
                        'GN Division Create',
                        'GN Division Update',
                        'GN Division Delete',
                    ]))

                    <li
                        class="dropdown {{ setSidebarActive(['admin.province.*', 'admin.district.*', 'admin.division.*', 'admin.gn-division.*']) }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>Region Structure</span></a>
                        <ul class="dropdown-menu">

                            @if (canAccess(['Province Index', 'Province Create', 'Province Update', 'Province Delete']))
                                <li class="{{ setSidebarActive(['admin.province.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.province.index') }}">Provinces </a>
                                </li>
                            @endif

                            @if (canAccess(['District Index', 'District Create', 'District Update', 'District Delete']))
                                <li class="{{ setSidebarActive(['admin.district.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.district.index') }}">Districts </a>
                                </li>
                            @endif

                            @if (canAccess(['DS Index', 'DS Create', 'DS Update', 'DS Delete']))
                                <li class="{{ setSidebarActive(['admin.division.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.division.index') }}">Divisional
                                        Secretariats</a>
                                </li>
                            @endif

                            @if (canAccess(['GN Division Index', 'GN Division Create', 'GN Division Update', 'GN Division Delete']))
                                <li class="{{ setSidebarActive(['admin.gn-division.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.gn-division.index') }}">GN
                                        Divisions</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- Access management --}}
                @if (canAccess([
                        'Permission Index',
                        'Permission Create',
                        'Permission Update',
                        'Permission Delete',
                        'User Role Index',
                        'User Role Create',
                        'User Role Update',
                        'User Role Delete',
                    ]))
                    <li
                        class="dropdown {{ setSidebarActive(['admin.permission.*', 'admin.role.*', 'admin.user-role.*']) }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-user-tag"></i>
                            <span>Access Management</span></a>
                        <ul class="dropdown-menu">

                            {{-- permission section --}}
                            @if (canAccess(['Permission Index', 'Permission Create', 'Permission Update', 'Permission Delete']))
                                <li class="{{ setSidebarActive(['admin.permission.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.permission.index') }}">Permissions</a>
                                </li>
                            @endif

                            {{-- user role section --}}
                            @if (canAccess(['User Role Index', 'User Role Create', 'User Role Update', 'User Role Delete']))
                                <li class="{{ setSidebarActive(['admin.role.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.role.index') }}">Roles &
                                        Permissions</a>
                                </li>

                                <li class="{{ setSidebarActive(['admin.user-role.*']) }}">
                                    <a class="nav-link" href="{{ route('admin.user-role.index') }}">User Roles</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (canAccess(['System Setting Index']))
                    <li class="{{ setSidebarActive(['admin.setting.*']) }}">
                        <a class="nav-link" href="{{ route('admin.setting.index') }}">
                            <i class="fas fa-cogs"></i>
                            <span>System Setting</span>
                        </a>
                    </li>
                @endif

            @endif
        </ul>
    </aside>
</div>
