        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>" class="brand-link">
      <img src= "<?php echo base_url()?>uploads/logo/Tato.png" alt="Sistema Reserva Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema de Reserva</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url()?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo session()->get('username')?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- <li class="header">MAIN NAVIGATION</li>  -->
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-calendar-check-o"></i>
                    <p>
                        Reserva
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: block;">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reserva">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>Reserva detalle</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reservadetallecliente">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Reserva detalle pasajero</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reservadetalletour">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>Reserva detalle tour</p>
                        </a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reservadetallehorariotren">
                            <i class="fa fa-subway nav-icon"></i>
                            <p>Reserva detalle tren</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>Reservadetallebus">
                            <i class="fa fa-bus nav-icon"></i>
                            <p>Reserva detalle Bus</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reservadetallehorarioticketmapi">
                            <i class="fa fa-file-pdf-o nav-icon"></i>
                            <p>Reserva detalle ticket Mapi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reservadetallehotelhabitacion">
                            <i class="fa fa-file-pdf-o nav-icon"></i>
                            <p>Reserva detalle Hotel</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>reservadetalleotroservicio">
                            <i class="fa fa-file-pdf-o nav-icon"></i>
                            <p>Reserva otros servicios</p>
                        </a>
                    </li>
                </ul>
            </li>  
            
            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>cliente">
                    <i class="fa fa-users nav-icon"></i>
                    <p>Clientes</p>
                </a>
            </li>
            
            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>hotel">
                    <i class="fa fa-hotel nav-icon"></i>
                    <p>Hotel</p>
                </a>
            </li>

            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>hotelhabitacion">
                    <i class="fa fa-bed nav-icon"></i>
                    <p>Hotel habitacion</p>
                </a>
            </li>            
            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>tour">
                    <i class="fa fa-camera nav-icon"></i>
                    <p>Tours</p>
                </a>
            </li>
           
            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>tren">
                    <i class="fa fa-subway nav-icon"></i>
                    <p>Tren</p>
                </a>
            </li>
            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>restaurante">
                    <i class="fa fa-spoon nav-icon"></i>
                    <p>Restaurante</p>
                </a>
            </li>
            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>clientetipo">
                    <i class="fa fa-file nav-icon"></i>
                    <p>Cliente tipo</p>
                </a>
            </li>

            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>ticketbus">
                    <i class="fa fa-file nav-icon"></i>
                    <p>Ticket bus</p>
                </a>
            </li>

            <li class='nav-item'>
                <a class="nav-link" href="<?php echo base_url();?>otroservicio">
                    <i class="fa fa-file nav-icon"></i>
                    <p>Otros servicio</p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                        Categorias
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">                    
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>cathotel">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Categoria Hotel</p>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>cathabitacion">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Categoria Habitacion</p>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>cattour">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Categoria Tour</p>
                        </a>
                    </li>
                </ul>
            </li>  
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clock"></i>
                    <p>
                        Horarios
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">                    
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>horarioticketmapi">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>Horario ticket mapi</p>
                        </a>
                    </li
                    ><li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>horaticketmapi">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>Hora ticket mapi</p>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>ticketmapi">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>ticket mapi</p>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>horariotren">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>Horario tren</p>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class="nav-link" href="<?php echo base_url();?>horatren">
                            <i class="fas fa-clock nav-icon"></i>
                            <p>Hora tren</p>
                        </a>
                    </li>
                </ul>
            </li> 
          <?php 
            // echo "<li class='nav-item has-treeview menu-open'>".
            //  "<a href='#' class='nav-link active'>".
            //  "<i class='nav-icon fas fa-tachometer-alt'></i>".
            //  "<p>PORTAL WEB<i class='right fas fa-angle-left'></i></p>".
            //  "</a>";
            // echo "<ul class='nav nav-treeview'";            
            // foreach ($activo as $value) {
            //     $Menu2 = base_url().$value->Controller;
            //     $URL = current_url();
            //     if ($Menu2 == $URL) {
            //         echo "<li class = 'nav-item'><a href='".$Menu2."'>".
            //         "<i class='".$value->Icono."'></i><p>".$value->Nombre."</p></a>".
            //         "</li>";
            //     } else {
            //         echo "<li class = 'nav-item'>".
            //         "<a href='".$Menu2."' class='nav-link'>".
            //         "<i class='".$value->Icono."'></i><p>".$value->Nombre."</p></a>".
            //         "</li>";
            //     }  
            // }
            // echo "</ul>".
            // "</li>";            
        ?>
        </ul>        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>