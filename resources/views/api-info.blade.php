<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Sistema de Gestión de Departamentos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: white;
            font-weight: bold;
        }
        
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            font-size: 16px;
        }
        
        .section {
            margin: 30px 0;
        }
        
        .section h2 {
            color: #667eea;
            font-size: 20px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .info-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
        
        .endpoint {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .method {
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .url {
            color: #333;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            flex: 1;
        }
        
        .status {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 20px;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            color: #666;
            font-size: 14px;
        }
        
        a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">H</div>
            <h1>API Sistema de Gestión de Departamentos</h1>
            <p class="subtitle">Reto Técnico - Helios</p>
            <span class="status">Operativo</span>
        </div>
        
        <div class="section">
            <h2>Información del Sistema</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Framework</div>
                    <div class="info-value">Laravel 12</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Base de Datos</div>
                    <div class="info-value">MySQL</div>
                </div>
                <div class="info-item">
                    <div class="info-label">PHP Version</div>
                    <div class="info-value">{{ PHP_VERSION }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Versión</div>
                    <div class="info-value">1.0.0</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h2>Endpoints Disponibles</h2>
            
            <div class="endpoint">
                <span class="method">GET</span>
                <span class="url">/api/departments</span>
            </div>
            
            <div class="endpoint">
                <span class="method">GET</span>
                <span class="url">/api/departments/{id}</span>
            </div>
            
            <div class="endpoint">
                <span class="method">POST</span>
                <span class="url">/api/departments</span>
            </div>
            
            <div class="endpoint">
                <span class="method">PUT</span>
                <span class="url">/api/departments/{id}</span>
            </div>
            
            <div class="endpoint">
                <span class="method">DELETE</span>
                <span class="url">/api/departments/{id}</span>
            </div>
            
            <div class="endpoint">
                <span class="method">GET</span>
                <span class="url">/api/departments/{id}/subdepartments</span>
            </div>
        </div>
        
        <div class="section">
            <h2>Acceso</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">API Base URL</div>
                    <div class="info-value">{{ url('/api') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Frontend</div>
                    <div class="info-value"><a href="http://localhost:3000" target="_blank">localhost:3000</a></div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Desarrollado como parte del Reto Técnico para Helios</p>
            <p style="margin-top: 10px;">
                <a href="/api/departments">Ver API</a> | 
                <a href="http://localhost:3000" target="_blank">Ir al Frontend</a>
            </p>
        </div>
    </div>
</body>
</html>

