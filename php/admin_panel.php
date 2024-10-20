<?php   
include 'db_connection.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}
include 'admin_header.php';

// Consultas para obtener la información necesaria
$eventCountQuery = "SELECT COUNT(*) AS total_eventos FROM eventos";
$eventCountResult = $conn->query($eventCountQuery);
$totalEventos = $eventCountResult->fetch_assoc()['total_eventos'];

$userCountQuery = "SELECT COUNT(*) AS total_usuarios FROM usuarios WHERE rol = 'usuario'";
$userCountResult = $conn->query($userCountQuery);
$totalUsuarios = $userCountResult->fetch_assoc()['total_usuarios'];

$adminCountQuery = "SELECT COUNT(*) AS total_admins FROM usuarios WHERE rol = 'admin'";
$adminCountResult = $conn->query($adminCountQuery);
$totalAdmins = $adminCountResult->fetch_assoc()['total_admins'];

$unansweredQueriesQuery = "SELECT COUNT(*) AS total_consultas FROM consultas WHERE respondido = 0";
$unansweredQueriesResult = $conn->query($unansweredQueriesQuery);
$totalUnansweredQueries = $unansweredQueriesResult->fetch_assoc()['total_consultas'];

$currentMonthEventsQuery = "SELECT COUNT(*) AS total_eventos_mes FROM eventos WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
$currentMonthEventsResult = $conn->query($currentMonthEventsQuery);
$totalEventosMes = $currentMonthEventsResult->fetch_assoc()['total_eventos_mes'];

// Consultar eventos de los próximos 6 meses a partir del mes actual
$eventsNext6MonthsQuery = "
    SELECT MONTH(fecha) AS mes, COUNT(*) AS total_eventos 
    FROM eventos 
    WHERE fecha >= CURRENT_DATE() 
    AND fecha < DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH) 
    GROUP BY MONTH(fecha) 
    ORDER BY MONTH(fecha)
";
$eventsNext6MonthsResult = $conn->query($eventsNext6MonthsQuery);

// Inicializar arreglos para los meses y los totales
$totales = array_fill(0, 6, 0); // 0 por defecto para los 6 meses
$meses = [];

// Rellenar los datos para el gráfico
while ($row = $eventsNext6MonthsResult->fetch_assoc()) {
    $meses[] = $row['mes'];
    $totales[$row['mes'] - date('n')] = $row['total_eventos']; // Ajustamos para que coincidan con los índices
}

// Nombres de los meses futuros
$nombresMeses = [];
for ($i = 0; $i < 6; $i++) {
    $nombresMeses[] = date('M', strtotime("+$i month"));
}

?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">


<div class="container mt-5">
    <h2 class="text-center mb-4">Resumen del Portal</h2>
    <div class="row">
        <!-- Tarjeta de Eventos -->
        <div class="col-md-3">
            <a href="admin_events.php" class="text-decoration-none text-dark">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Eventos</h5>
                        <p class="card-text"><?php echo $totalEventos; ?></p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta de Usuarios -->
        <div class="col-md-3">
            <a href="admin_users.php" class="text-decoration-none text-dark">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text"><?php echo $totalUsuarios; ?></p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta de Administradores -->
        <div class="col-md-3">
            <a href="admin_admins.php" class="text-decoration-none text-dark">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Administradores</h5>
                        <p class="card-text"><?php echo $totalAdmins; ?></p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta de Consultas No Respondidas -->
        <div class="col-md-3">
            <a href="admin_consultations.php" class="text-decoration-none text-dark">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Consultas No Respondidas</h5>
                        <p class="card-text"><?php echo $totalUnansweredQueries; ?></p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta de Eventos Este Mes -->
        <div class="col-md-3 mt-4">
            <a href="admin_events.php" class="text-decoration-none text-dark">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Eventos Este Mes</h5>
                        <p class="card-text"><?php echo $totalEventosMes; ?></p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Gráfico de Eventos por Mes -->



    <div class="row mt-5">
    <div class="col-md-12 text-center">
        <h4>Eventos por Mes (Próximos 6 Meses)</h4>
        <div class="chart-container" style="display: flex; justify-content: center;"> 
            <canvas id="eventsChart" style="max-width: 700px; max-height: 300px;"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('eventsChart').getContext('2d');
    document.getElementById('eventsChart').width = 700;  
    document.getElementById('eventsChart').height = 400; 

    const eventsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($nombresMeses); ?>,
            datasets: [{
                label: 'Total de Eventos',
                data: <?php echo json_encode($totales); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div> <!
<?php
include 'footer.php';
?>