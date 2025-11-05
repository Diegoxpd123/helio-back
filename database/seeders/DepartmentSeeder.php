<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    private $ambassadorNames = [
        'Jordyn Herwitz', 'Carla Siphron', 'Terry Press', 'Kierra Rosser',
        'Miles Esther', 'Lincoln Lipshutz', 'Ahmad Herwitz', 'Kadin Bergson',
        'Gustavo Bergson', 'Angel Schleifer', 'Lydia Gouse', 'Marcus Davis',
        'Sofia Rodriguez', 'James Wilson', 'Emma Thompson', 'Oliver Martinez',
        'Isabella Anderson', 'Lucas Brown', 'Mia Taylor', 'Ethan Moore',
        'Charlotte Jackson', 'Alexander Lee', 'Amelia White', 'Benjamin Harris',
        'Harper Martin', 'Daniel Thompson', 'Evelyn Garcia', 'Matthew Robinson',
        'Abigail Clark', 'Michael Lewis', 'Emily Walker', 'William Hall',
    ];

    public function run(): void
    {
        // Limpiar tabla
        Department::truncate();

        // NIVEL 1: Departamentos raíz
        $ceo = $this->createDepartment('CEO', null, 'Jordyn Herwitz');
        $direccionGeneral = $this->createDepartment('Dirección general', null);

        // NIVEL 2: Departamentos principales
        $marketing = $this->createDepartment('Marketing', $direccionGeneral->id, 'Carla Siphron');
        $producto = $this->createDepartment('Producto', $direccionGeneral->id);
        $operaciones = $this->createDepartment('Operaciones', $direccionGeneral->id, 'Terry Press');
        $strategy = $this->createDepartment('Strategy', $direccionGeneral->id, 'Kierra Rosser');
        $finanzas = $this->createDepartment('Finanzas', $direccionGeneral->id, 'Gustavo Bergson');
        $recursosHumanos = $this->createDepartment('Recursos Humanos', $direccionGeneral->id, 'Angel Schleifer');

        // NIVEL 2: Subdepartamentos de Marketing
        $ventas = $this->createDepartment('Ventas', $marketing->id, 'Lydia Gouse');
        $comunicaciones = $this->createDepartment('Comunicaciones', $marketing->id);
        $brandManagement = $this->createDepartment('Brand Management', $marketing->id, 'Marcus Davis');
        $publicidad = $this->createDepartment('Publicidad', $marketing->id);

        // NIVEL 2: Subdepartamentos de Producto
        $growth = $this->createDepartment('Growth', $producto->id);
        $diseno = $this->createDepartment('Diseño', $producto->id, 'Miles Esther');
        $ingenieria = $this->createDepartment('Ingeniería', $producto->id, 'Lincoln Lipshutz');
        $uxResearch = $this->createDepartment('UX Research', $producto->id, 'Sofia Rodriguez');

        // NIVEL 2: Subdepartamentos de Operaciones
        $finanzasOp = $this->createDepartment('Finanzas Operativas', $operaciones->id);
        $logistica = $this->createDepartment('Logística', $operaciones->id, 'James Wilson');
        $procurement = $this->createDepartment('Procurement', $operaciones->id);

        // NIVEL 2: Subdepartamentos de Strategy
        $analytics = $this->createDepartment('Analytics', $strategy->id);
        $businessIntel = $this->createDepartment('Business Intelligence', $strategy->id, 'Emma Thompson');

        // NIVEL 2: Subdepartamentos de Finanzas
        $contabilidad = $this->createDepartment('Contabilidad', $finanzas->id, 'Oliver Martinez');
        $tesoreria = $this->createDepartment('Tesorería', $finanzas->id);
        $auditoria = $this->createDepartment('Auditoría', $finanzas->id);

        // NIVEL 2: Subdepartamentos de Recursos Humanos
        $reclutamiento = $this->createDepartment('Reclutamiento', $recursosHumanos->id, 'Isabella Anderson');
        $capacitacion = $this->createDepartment('Capacitación', $recursosHumanos->id);
        $nominas = $this->createDepartment('Nóminas', $recursosHumanos->id);
        $bienestar = $this->createDepartment('Bienestar Laboral', $recursosHumanos->id);

        // NIVEL 3: Subdepartamentos de Ingeniería
        $frontend = $this->createDepartment('Frontend', $ingenieria->id, 'Ahmad Herwitz');
        $backend = $this->createDepartment('Backend', $ingenieria->id, 'Kadin Bergson');
        $devops = $this->createDepartment('DevOps', $ingenieria->id);
        $qa = $this->createDepartment('QA Testing', $ingenieria->id, 'Lucas Brown');
        $mobile = $this->createDepartment('Mobile', $ingenieria->id);

        // NIVEL 3: Subdepartamentos de Ventas
        $ventasB2B = $this->createDepartment('Ventas B2B', $ventas->id, 'Mia Taylor');
        $ventasB2C = $this->createDepartment('Ventas B2C', $ventas->id);
        $customerSuccess = $this->createDepartment('Customer Success', $ventas->id, 'Ethan Moore');

        // NIVEL 3: Subdepartamentos de Diseño
        $uiDesign = $this->createDepartment('UI Design', $diseno->id, 'Charlotte Jackson');
        $productDesign = $this->createDepartment('Product Design', $diseno->id);
        $brandDesign = $this->createDepartment('Brand Design', $diseno->id);

        // NIVEL 3: Subdepartamentos de Comunicaciones
        $redeSociales = $this->createDepartment('Redes Sociales', $comunicaciones->id, 'Alexander Lee');
        $prensa = $this->createDepartment('Prensa', $comunicaciones->id);
        $contenido = $this->createDepartment('Contenido Digital', $comunicaciones->id);

        // NIVEL 4: Subdepartamentos de Frontend
        $reactTeam = $this->createDepartment('React Team', $frontend->id, 'Amelia White');
        $vueTeam = $this->createDepartment('Vue Team', $frontend->id);

        // NIVEL 4: Subdepartamentos de Backend
        $apiTeam = $this->createDepartment('API Team', $backend->id, 'Benjamin Harris');
        $databaseTeam = $this->createDepartment('Database Team', $backend->id);

        // NIVEL 4: Subdepartamentos de DevOps
        $infrastructure = $this->createDepartment('Infraestructura', $devops->id);
        $monitoring = $this->createDepartment('Monitoreo', $devops->id);

        // Departamentos adicionales
        $legal = $this->createDepartment('Legal', $direccionGeneral->id, 'Harper Martin');
        $compliance = $this->createDepartment('Compliance', $legal->id);
        $itSupport = $this->createDepartment('IT Support', $operaciones->id, 'Daniel Thompson');
        $seguridad = $this->createDepartment('Seguridad', $operaciones->id);
        $innovacion = $this->createDepartment('Innovación', $strategy->id, 'Evelyn Garcia');
        $partnerships = $this->createDepartment('Partnerships', $strategy->id);
        
        // Más departamentos para alcanzar 50+
        $this->createBulkDepartments();
    }

    private function createDepartment(string $name, ?int $parentId, ?string $ambassador = null): Department
    {
        return Department::create([
            'name' => $name,
            'parent_department_id' => $parentId,
            'level' => rand(1, 5),
            'employees_count' => rand(1, 20),
            'ambassador_name' => $ambassador,
        ]);
    }

    private function createBulkDepartments(): void
    {
        $allDepartments = Department::all();
        $parentDepts = $allDepartments->where('sub_departments_count', '<', 5)->pluck('id')->toArray();

        $bulkDepts = [
            'E-commerce',
            'Marketplace',
            'Data Science',
            'Machine Learning',
            'Cloud Services',
            'Network Security',
            'Internal Communications',
            'External Relations',
            'Corporate Strategy',
            'Market Research',
            'Product Analytics',
            'User Acquisition',
            'Retention',
            'Revenue Operations',
            'Sales Operations',
            'Marketing Operations',
            'Technical Support',
            'Customer Care',
            'Account Management',
            'Project Management',
            'Agile Coaching',
            'Scrum Masters',
            'Documentation',
            'Knowledge Management',
            'Learning & Development',
            'Talent Acquisition',
            'Employer Branding',
            'Compensation & Benefits',
            'Performance Management',
            'Employee Relations',
        ];

        foreach ($bulkDepts as $index => $name) {
            if ($index < count($parentDepts)) {
                $this->createDepartment($name, $parentDepts[$index], $this->getRandomAmbassador());
            }
        }
    }

    private function getRandomAmbassador(): ?string
    {
        return rand(0, 2) === 0 ? null : $this->ambassadorNames[array_rand($this->ambassadorNames)];
    }
}
