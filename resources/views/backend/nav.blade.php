<div id="sidebar-menu">
    <ul class="sidebar-links" id="simple-bar">
        <li class="back-btn"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{ asset('/backend/assets/images/logo/devi-logo.png') }}" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
        </li>
        <li class="pin-title sidebar-main-title">
            <div>
                <h6>Pinned</h6>
            </div>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6 class="lan-1">General</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                </svg>
                <span class="lan-3">Dashboard </span>
            </a>
            <ul class="sidebar-submenu">
                <li><a class="" href="{{ route('dashboard') }}">Patient Register</a></li>
                <li><a class="" href="{{ route('store.order') }}">Order Register</a></li>
                <li><a class="" href="{{ route('pharmacy.order') }}">Pharmacy Register</a></li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6 class="">Operations</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-contact') }}"></use>
                </svg>
                <span>Appointment</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('appointments') }}">Appointment Register</a></li>
                <li><a href="{{ route('appointment.list') }}">Today's Appointment</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-to-do') }}"></use>
                </svg>
                <span>Consultation</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('patients') }}">Patient Register</a></li>
                <li><a href="{{ route('consultations') }}">Consultation Register</a></li>
                <li><a href="{{ route('mrecords') }}">Medical Record Register</a></li>
                <li><a href="{{ route('patient.procedures') }}">Patient Procedure Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#customers') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#customers') }}"></use>
                </svg>
                <span>User & Roles</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('users') }}">User Register</a></li>
                <li><a href="{{ route('roles') }}">Roles & Permissions</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-learning') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-learning') }}"></use>
                </svg>
                <span>Branch Management</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('branches') }}">Branch Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                </svg>
                <span>Doctor Management</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('doctors') }}">Doctor Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-file') }}"></use>
                </svg>
                <span>Procedure Management</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('procedures') }}">Procedure Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                </svg>
                <span>Camp</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('camps') }}">Camp Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#doller-return') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#doller-return') }}"></use>
                </svg>
                <span>Income & Expenses</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('heads') }}">Heads</a></li>
                <li><a href="{{ route('iande') }}">Income & Expense Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-knowledgebase') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-knowledgebase') }}"></use>
                </svg>
                <span>Documents</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('documents') }}">Document Register</a></li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6>Order</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                </svg>
                <span>Store</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('store.order') }}">Order Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-form') }}"></use>
                </svg>
                <span>Pharmacy</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('pharmacy.order') }}">Pharmacy Order Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-social') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-social') }}"></use>
                </svg>
                <span>Transfer</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('pending.transfer') }}">Pending Transfer Register</a></li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6>Payments</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#doller-return') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#doller-return') }}"></use>
                </svg>
                <span>Payments</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('patient.payments') }}">Payment Register</a></li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6>Inventory</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-others') }}"></use>
                </svg>
                <span>Product</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a class="submenu-title" href="javascript:void(0)">Pharmacy<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="{{ route('product.pharmacy') }}">Pharmacy List</a></li>
                        <li><a href="{{ route('pharmacy.purchase') }}">Pharmacy Purchase</a></li>
                        <li><a href="{{ route('pharmacy.transfer') }}">Pharmacy Transfer</a></li>
                    </ul>
                </li>
                <li><a class="submenu-title" href="javascript:void(0)">Frame<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="{{ route('product.frame') }}">Frame List</a></li>
                        <li><a href="{{ route('frame.purchase') }}">Frame Purchase</a></li>
                        <li><a href="{{ route('frame.transfer') }}">Frame Transfer</a></li>
                    </ul>
                </li>
                <li><a class="submenu-title" href="javascript:void(0)">Lens<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="{{ route('product.lens') }}">Lens List</a></li>
                        <li><a href="{{ route('lens.purchase') }}">Lens Purchase</a></li>
                        <li><a href="{{ route('lens.transfer') }}">Lens Transfer</a></li>
                    </ul>
                </li>
                <li><a class="submenu-title" href="javascript:void(0)">Service<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="{{ route('product.service') }}">Service List</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-builders') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-builders') }}"></use>
                </svg>
                <span>Supplier</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('suppliers') }}">Supplier Register</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                </svg>
                <span>Manufacturer</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('manufacturers') }}">Manufacturer Register</a></li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6>Reports</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                </svg>
                <span>Forms</span>
            </a>
            <ul class="sidebar-submenu">
                <li><a class="submenu-title" href="#">Form Controls<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="form-validation.html">Form Validation</a></li>
                        <li><a href="base-input.html">Base Inputs</a></li>
                        <li><a href="radio-checkbox-control.html">Checkbox & Radio</a></li>
                        <li><a href="input-group.html">Input Groups</a></li>
                        <li> <a href="input-mask.html">Input Mask</a></li>
                        <li><a href="megaoptions.html">Mega Options</a></li>
                    </ul>
                </li>
                <li><a class="submenu-title" href="#">Form Widgets<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="datepicker.html">Datepicker</a></li>
                        <li><a href="touchspin.html">Touchspin</a></li>
                        <li><a href="select2.html">Select2</a></li>
                        <li><a href="switch.html">Switch</a></li>
                        <li><a href="typeahead.html">Typeahead</a></li>
                        <li><a href="clipboard.html">Clipboard</a></li>
                    </ul>
                </li>
                <li><a class="submenu-title" href="#">Form layout<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                    <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="form-wizard.html">Form Wizard 1</a></li>
                        <li><a href="form-wizard-two.html">Form Wizard 2</a></li>
                        <li><a href="two-factor.html">Two Factor</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
                <h6>Settings</h6>
            </div>
        </li>
        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)">
                <svg class="stroke-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-ui-kits') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#fill-ui-kits') }}"></use>
                </svg><span>Ui Kits</span></a>
            <ul class="sidebar-submenu">
                <li><a href="typography.html">Typography</a></li>
                <li><a href="avatars.html">Avatars</a></li>
                <li><a href="helper-classes.html">helper classes</a></li>
                <li><a href="grid.html">Grid</a></li>
                <li><a href="tag-pills.html">Tag & pills</a></li>
                <li><a href="progress-bar.html">Progress</a></li>
                <li><a href="modal.html">Modal</a></li>
                <li><a href="alert.html">Alert</a></li>
                <li><a href="popover.html">Popover</a></li>
                <li><a href="tooltip.html">Tooltip</a></li>
                <li><a href="dropdown.html">Dropdown</a></li>
                <li><a href="according.html">Accordion</a></li>
                <li><a href="tab-bootstrap.html">Tabs</a></li>
                <li><a href="list.html">Lists</a></li>
            </ul>
        </li>
    </ul>
</div>