
# 📄 2️⃣ `README.pt-BR.md` (PORTUGUÊS)

```md
# Projeto Dízimo

📘 Leia este README em inglês: [README.md](README.md)

O **Projeto Dízimo** é um sistema web desenvolvido para auxiliar instituições religiosas no controle de membros, doações e transparência financeira, promovendo organização, segurança e clareza na gestão.

O sistema foi projetado para uso real, com separação de perfis, controle de acesso e foco em boas práticas de desenvolvimento.

---

## 🎯 Objetivo do Projeto

- Centralizar o registro de doações (dízimos e ofertas)
- Permitir que membros acompanhem suas próprias contribuições
- Oferecer transparência financeira por meio de relatórios consolidados
- Facilitar a administração de receitas e despesas da instituição

---

## 🧩 Funcionalidades

### 👤 Membros
- Cadastro de membros
- Visualização de doações pessoais
- Definição de dízimo mensal previsto
- Acesso ao painel de transparência financeira

### 🛡️ Administração
- Cadastro e gerenciamento de usuários
- Controle de permississões por nível de acesso
- Registro de doações, receitas e despesas
- Relatórios por período (mês, ano ou intervalo)
- Comparativo entre dízimo previsto x realizado

### 📊 Transparência
- Painel com dados financeiros consolidados
- Relatórios acessíveis aos membros

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8+**
- **Laravel 12**
- **MySQL**
- **Blade Templates**
- **Tailwind CSS**
- **Git & GitHub**

---

## 🧱 Arquitetura e Organização

- Arquitetura MVC (Model–View–Controller)
- Separação clara entre:
  - Painel administrativo
  - Área do membro
  - Área pública
- Services dedicados para regras de negócio
- Uso de migrations e seeders
- Controle de acesso baseado em roles

---

## 🔐 Controle de Acesso

O sistema utiliza níveis de acesso para garantir segurança e organização:

- Administrador
- Usuário / Membro
- Papéis específicos como **Tesoureiro**, **Auxiliar** e **Secretário**

---

## 🚀 Fluxo de Desenvolvimento e Deploy

O projeto segue um fluxo profissional de versionamento:

- `localdev`: desenvolvimento local
- `main`: produção

Fluxo:
1. Desenvolvimento na `localdev`
2. Commit e push para o GitHub
3. Merge para a `main`
4. Deploy em produção

---

## ⚙️ Instalação Local

```bash
git clone https://github.com/Andre-1845/dizimo.git
cd dizimo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
