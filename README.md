# Author: Joven Rey V. Flores
# BSIT SET B = 2021 - 2025
# GREEN VALLEY COLLEGE FOUNDATION INC.
# BEST CAPSTONE OF THE YEAR

# 🏥 Health Center Information System - Lutayan, Sultan Kudarat

A comprehensive, modular, and secure health center information system built for managing medical records, patient profiles, checkups, vaccinations, birthing monitoring, and financial support within the Municipality of Lutayan, Sultan Kudarat.

---

## 🚀 Features

### 🧑‍⚕️ Patient Management
- Add, edit, and view detailed patient records
- Upload and display profile photos
- Manage family addresses and membership details
- Track deceased members and their related information
- Advanced search functionality

### 📋 Medical Checkups
- Record physical exams: HEENT, chest, abdomen, GU, neuro, and more
- Input past medical history, allergies, and current condition
- Store doctor’s and nurse’s notes
- Generate printable medical certificates (for illness or work)

### 🧪 Laboratory & Medical Files
- Upload laboratory test results with file support
- View historical lab records and associated images

### 💉 Vaccination Module (including Animal Bite Care)
- Track doses from D0 to D28/30 with manual next-visit scheduling
- Status tracking: pending, completed, active/inactive
- Only shows current, relevant vaccination records
- Remarks per dose and automatic dose status incrementation

### 🤰 Birthing and Delivery Monitoring
- Store birthing and postpartum records
- Delivery information, vital signs, medications, IV fluids
- Record doctor and nurse notes
- Linked tables: `tbl_birth_info` and `tbl_birthing_monitoring`

### 📝 Referrals
- Confirm referral through modal (Yes/No)
- Record, track, and manage patient referrals

### 💊 Prescription Management
- Generate and print patient prescriptions with hospital logo
- View full medication history in modals
- Organized display per patient

### 👥 User & Role Management
- Add users: admin, doctor, nurse, staff
- Role-based permissions
- 2FA via Google Authenticator
- Secure authentication & session management
- Upload profile picture
- Activity logging & audit trails

### 🗓️ Doctor Schedules
- Manage and prevent duplicate doctor schedules
- Daily/weekly schedule setup with validation

### 📊 Dashboard & Reporting
- Visual summaries of:
  - Deceased members
  - Released financial support
  - Vaccination progress
  - Prenatal and postnatal monitoring
- Date filters, search, and sortable tables
- CSV and Excel export supported

### 💸 Money Releasing / Financial Aid
- Manage patient financial support and contributions
- View coordinator-based released amounts
- Tabbed view for pending and approved releases

---

## 🛠️ System Architecture

- ✅ PHP (OOP / MVC Pattern)
- ✅ MySQL (PDO/MySQLi)
- ✅ FilamentPHP for modern UI components
- ✅ TailwindCSS custom theme
- ✅ JavaScript enhancements for dynamic forms
- ✅ Secure image/file upload handling
- ✅ Multiselect (Select2 or Bootstrap-Multiselect)
- ✅ CSV/Excel Import and Export
- ✅ Fully responsive design

---

## 📦 Installation

```bash
git clone https://github.com/yourusername/health-center-system.git
cd health-center-system
composer install
cp .env.example .env
php artisan key:generate


