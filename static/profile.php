<!DOCTYPE html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Portal - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Patient Portal</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="dashboard.html"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="appointments.html"><i class="bi bi-calendar-event me-2"></i>Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="messages.html"><i class="bi bi-chat-dots me-2"></i>Messages</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-lines-fill me-2"></i>Contacts</a></li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>MEDICAL</span></h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="results.html"><i class="bi bi-file-earmark-text me-2"></i>Test Results</a></li>
                        <li class="nav-item"><a class="nav-link" href="records.html"><i class="bi bi-journal-medical me-2"></i>Medical Records</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-capsule me-2"></i>Medications</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-clipboard2-pulse me-2"></i>Care plans</a></li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>FINANCE</span></h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="billing.html"><i class="bi bi-credit-card me-2"></i>Billing</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-clock-history me-2"></i>History</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph me-2"></i>Reports</a></li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>SETTINGS</span></h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="profile.html"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="settings.html"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-question-circle me-2"></i>Help/FAQ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-headset me-2"></i>Support</a></li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="profile-header text-center">
                    <img src="https://ui-avatars.com/api/?name=Bwalya+Chisanga&size=150&background=random" class="rounded-circle mb-3 shadow-sm" alt="Bwalya Chisanga" width="150" height="150">
                    <h1 class="h3">Bwalya Chisanga</h1>
                    <p class="text-muted">Patient ID: PA001234</p>
                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square me-1"></i> Edit Profile Picture</button>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <label for="firstName" class="col-sm-3 col-form-label">Full Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="fullName" value="Bwalya Chisanga">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="dob" value="January 15, 1985">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="gender" value="Male">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" readonly class="form-control-plaintext" id="email" value="bwalya.chisanga@example.com">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="tel" readonly class="form-control-plaintext" id="phone" value="+260 977 123456">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit Personal Info</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Address Information</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="address" value="Plot 123, Independence Avenue">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="city" class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="city" value="Lusaka">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="country" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="country" value="Zambia">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit Address</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Emergency Contact</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <label for="emergencyName" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="emergencyName" value="Mutinta Banda">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="emergencyRelationship" class="col-sm-3 col-form-label">Relationship</label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" id="emergencyRelationship" value="Spouse">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="emergencyPhone" class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="tel" readonly class="form-control-plaintext" id="emergencyPhone" value="+260 966 987654">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit Emergency Contact</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script src="dashboard.js"></script>
    </body>
</html>