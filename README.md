# Sistema de Vacinação

## Instalação

1. Importe `sql/sistema_vacinacao.sql` no MySQL (Localhost/phpmyadmin)
2. Configure `config/conexao.php`
3. Rode: `php -S localhost:8000 -t public`
4. Acesse: [http://localhost:8000](http://localhost:8000/public/index.php)
5. Xampp (Apache/MySql) / Start

## Usuários de Teste

- Recepcionista: <carla@email.com> / senha1234
- Paciente: <maria2@email.com> / senha1234
- Enfermeiro: <juliana@email.com> / senha1234
- Farmacêutico: <elaine.castro@email.com> / senha1234
- Administrador : <admin@email.com>/ senha 1234

## Permissões por Perfil

| Perfil        | Ações Permitidas |
|---------------|------------------|
| Recepcionista | CRUD de Pacientes |
| Paciente      | Agendar vacinação, Consultar histórico |
| Enfermeiro    | Registrar vacinações e doses |
| Farmacêutico  | CRUD de Vacinas |
| Administrador  | CRUD para Todos |

---

© Sistema de Vacinação - Instituto Federal SP/GRU @2025
Desenvolvido por @julirmatos
----------------------------
