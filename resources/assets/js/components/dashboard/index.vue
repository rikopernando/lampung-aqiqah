<template>
  <div>
    <div class="wrapper">
          <!-- Sidebar Holder -->
          <nav id="sidebar">
              <div class="sidebar-header">
                  <h3>Aqiqah Lampung</h3>
              </div>

              <ul class="list-unstyled components">
                  <p>Menu Sidebar</p>
                  <li>
                      <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebarLink">Home</a>
                      <ul class="collapse list-unstyled" id="homeSubmenu">
                          <li>
                              <a class="sidebarLink" href="#">Home 1</a>
                          </li>
                          <li>
                              <a class="sidebarLink" href="#">Home 2</a>
                          </li>
                          <li>
                              <a class="sidebarLink" href="#">Home 3</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <a class="sidebarLink" href="#">About</a>
                      <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebarLink">Pages</a>
                      <ul class="collapse list-unstyled" id="pageSubmenu">
                          <li>
                              <a class="sidebarLink" href="#">Page 1</a>
                          </li>
                          <li>
                              <a class="sidebarLink" href="#">Page 2</a>
                          </li>
                          <li>
                              <a class="sidebarLink" href="#">Page 3</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <a class="sidebarLink" href="#">Portfolio</a>
                  </li>
                  <li>
                      <a class="sidebarLink" href="#">Contact</a>
                  </li>
              </ul>
          </nav>

          <!-- Page Content Holder -->
          <div id="content">
              <nav style="margin: 0" class="navbar navbar-expand-sm navbar-light">
                  <div class="container-fluid">

                      <div id="sidebarCollapse" class="navbar-btn">
                          <span></span>
                          <span></span>
                          <span></span>
                      </div>
            <!-- <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <i class="fas fa-align-justify"></i>
                      </button> -->
          <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
             <!-- <ul class="nav navbar-nav ml-auto">
                              <li class="nav-item">
                                  <a class="nav-link btn btn-danger" href="#">Logout</a>
                              </li>
                          </ul> -->
            <button class="btn btn-danger btn-lg ml-auto">Logout</button>
                    <!-- </div>  -->
                  </div>
              </nav>
              
              <slot>
              </slot>
          </div>
      </div>
  </div>
</template>
<script></script>