<section class="dashboard">
    <div class="dashboard-header">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p class="user-type"><?php echo ucfirst($user['type']); ?></p>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-sidebar">
            <nav class="dashboard-nav">
                <a href="/dashboard" class="dashboard-nav-item active">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="/dashboard/profile" class="dashboard-nav-item">
                    <i class="fas fa-user"></i>
                    My Profile
                </a>
                <a href="/dashboard/settings" class="dashboard-nav-item">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
                <a href="/logout" class="dashboard-nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </div>

        <div class="dashboard-content">
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Quick Stats</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value">0</span>
                            <span class="stat-label">Connections</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">0</span>
                            <span class="stat-label">Messages</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">0</span>
                            <span class="stat-label">Notifications</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3>Recent Activity</h3>
                    <div class="activity-list">
                        <p class="empty-state">No recent activity</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3>Recommended Connections</h3>
                <div class="connections-list">
                    <p class="empty-state">No recommended connections yet</p>
                </div>
            </div>
        </div>
    </div>
</section> 