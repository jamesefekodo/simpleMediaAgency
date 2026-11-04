  <aside class="admin-sidebar" id="adminSidebar">
      <a class="sidebar-brand" href="{{ route('adminDashboard') }}">
          <img src="{{ logo() }}" alt="Logo">
          <div>
              <strong>{{ basicSystemInfo()->acronym ?? config('app.name') }}</strong>
              <span>Admin Console</span>
          </div>
      </a>

      <nav class="sidebar-nav">
          <div class="sidebar-label">Overview</div>

          <a class="sidebar-link {{ Str::startsWith(request()->path(), 'admin/dashboard') ? 'active' : '' }}"
              href="{{ route('adminDashboard') }}">
              <i class="fa-solid fa-chart-pie"></i> Dashboard
          </a>

          <a class="sidebar-link" href="#">
              <i class="fa-solid fa-chart-line"></i> Analytics
          </a>

          <div class="sidebar-label">Commerce</div>
          <div class="nav-item">
              <button class="nav-dropdown-button {{ Str::startsWith(request()->path(), 'admin/shop') ? 'active' : '' }}"
                  type="button" aria-expanded="false">
                  <i class="fa-solid fa-store"></i>
                  Shop
                  <i class="fa-solid fa-chevron-down dropdown-caret"></i>
              </button>

              <div class="nav-dropdown">
                  <div class="nav-dropdown-items">

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-truck-fast"></i> Orders
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-cubes"></i> Products
                      </a>

                      @if (Auth::user()->hasPermission('product_category.read'))
                          <a class="nav-sub-link {{ Str::startsWith(request()->path(), 'admin/shop/categories') ? 'active' : '' }}"
                              href="{{ route('productCategories') }}">
                              <i class="fa-solid fa-folder-tree"></i> Categories
                          </a>
                      @endif
                      @if (Auth::user()->hasPermission('brands.read'))
                          <a class="nav-sub-link {{ Str::startsWith(request()->path(), 'admin/shop/brand') ? 'active' : '' }}"
                              href="{{ route('brands') }}">
                              <i class="fa-solid fa-tags"></i> Brands
                          </a>
                      @endif
                      @if (Auth::user()->hasPermission('colour.read'))
                          <a class="nav-sub-link {{ Str::startsWith(request()->path(), 'admin/shop/colours') ? 'active' : '' }}"
                              href="{{ route('colours') }}">
                              <i class="fa-solid fa-palette"></i> Colours
                          </a>
                      @endif
                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-ruler-combined"></i> Weight
                      </a>
                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-ruler-combined"></i> Other Attributes
                      </a>
                  </div>
              </div>
          </div>

          <div class="nav-item">
              <button class="nav-dropdown-button" type="button" aria-expanded="false">
                  <i class="fa-solid fa-box"></i>
                  Products
                  <i class="fa-solid fa-chevron-down dropdown-caret"></i>
              </button>

              <div class="nav-dropdown">
                  <div class="nav-dropdown-items">
                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-circle-dot"></i> All Products
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-plus"></i> Add Product
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-tags"></i> Categories
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-boxes-stacked"></i> Inventory
                      </a>
                  </div>
              </div>
          </div>

          <div class="nav-item">
              <button class="nav-dropdown-button" type="button" aria-expanded="false">
                  <i class="fa-solid fa-receipt"></i>
                  Orders
                  <i class="fa-solid fa-chevron-down dropdown-caret"></i>
              </button>

              <div class="nav-dropdown">
                  <div class="nav-dropdown-items">
                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-circle-dot"></i> All Orders
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-clock"></i> Pending Orders
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-truck"></i> Shipments
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-rotate-left"></i> Refunds
                      </a>
                  </div>
              </div>
          </div>

          <a class="sidebar-link" href="#">
              <i class="fa-solid fa-users"></i> Customers
          </a>

          <a class="sidebar-link" href="#">
              <i class="fa-solid fa-wallet"></i> Transactions
          </a>

          <div class="sidebar-label">System</div>

          <div class="nav-item {{ Str::startsWith(request()->path(), 'admin/config') ? 'active' : '' }}">
              <button class="nav-dropdown-button" type="button" aria-expanded="false">
                  <i class="fa-solid fa-gear"></i>
                  Config
                  <i class="fa-solid fa-chevron-down dropdown-caret"></i>
              </button>

              <div class="nav-dropdown">
                  <div class="nav-dropdown-items">
                      @if (Auth::user()->hasPermission('policy.read'))
                          <a class="nav-sub-link {{ Str::startsWith(request()->path(), 'admin/config/policies') ? 'active' : '' }}"
                              href="{{ route('policies') }}">
                              <i class="fa-solid fa-shield-halved"></i> Policies
                          </a>
                      @endif

                      {{-- <a class="nav-sub-link" href="#">
                                <i class="fa-solid fa-plus"></i> Create Policy
                            </a>

                            <a class="nav-sub-link" href="#">
                                <i class="fa-solid fa-file-shield"></i> Policy Categories
                            </a> --}}
                  </div>
              </div>
          </div>

          <div class="nav-item">
              <button class="nav-dropdown-button" type="button" aria-expanded="false">
                  <i class="fa-solid fa-user-shield"></i>
                  Administration
                  <i class="fa-solid fa-chevron-down dropdown-caret"></i>
              </button>

              <div class="nav-dropdown">
                  <div class="nav-dropdown-items">
                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-users-gear"></i> Administrators
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-user-lock"></i> Roles
                      </a>

                      <a class="nav-sub-link" href="#">
                          <i class="fa-solid fa-key"></i> Permissions
                      </a>
                  </div>
              </div>
          </div>

          <a class="sidebar-link" href="#">
              <i class="fa-solid fa-gear"></i> Settings
          </a>
      </nav>

      <div class="sidebar-footer">
          <div class="sidebar-user">
              <div class="sidebar-user-avatar">
                  {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
              </div>

              <div>
                  <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                  <span>{{ auth()->user()->email ?? 'admin@example.com' }}</span>
              </div>
          </div>
      </div>
  </aside>
