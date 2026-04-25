<?php $__env->startSection('title', 'Kontrol Merkezi | Nöbet Kontrol'); ?>
<?php $__env->startSection('page-title', 'Sistem Yönetim Paneli'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hızlı İstatistik Kartları -->
    <!-- Hızlı İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(147, 51, 234, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Öğretmen Kadrosu</div>
                        <h3 class="mb-0 fw-bold text-white"><?php echo e($stats['totalTeachers']); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Aktif Noktalar</div>
                        <h3 class="mb-0 fw-bold text-white"><?php echo e($stats['totalLocations']); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Bugünkü Görev</div>
                        <h3 class="mb-0 fw-bold text-white"><?php echo e($stats['todayAssignments']); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(185, 28, 28, 0.05) 100%) !important;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-danger text-white shadow-sm" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <i class="bi bi-arrow-left-right fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-opacity-50 small fw-bold text-uppercase letter-spacing-1" style="font-size: 10px;">Takas Talebi</div>
                        <h3 class="mb-0 fw-bold text-white"><?php echo e($stats['pendingSwaps']); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Kolon: Anlık Akış -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-broadcast fs-5"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Canlı Nöbet Akışı</h6>
                    </div>
                    <?php if($todaySchedule): ?>
                        <a href="<?php echo e(route('schedules.show', $todaySchedule)); ?>" class="btn btn-dark btn-sm rounded-3 py-1 px-3 shadow-sm border-0" style="background: rgba(255,255,255,0.05); font-size: 12px;">
                            Tüm Liste <i class="bi bi-arrow-right ms-1 text-primary"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if($todaySchedule && $todaySchedule->assignments->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th class="ps-4 text-white-50">Öğretmen</th>
                                        <th class="text-white-50">Nöbet Alanı</th>
                                        <th class="text-center text-white-50">Periyot</th>
                                        <th class="text-center text-white-50">Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $todaySchedule->assignments->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-box" style="width:30px;height:30px;font-size:12px;border-radius:10px;">
                                                        <?php echo e(strtoupper(substr($assignment->teacher->name, 0, 1))); ?>

                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-light"><?php echo e($assignment->teacher->name); ?></div>
                                                        <div class="text-white-50 small opacity-75" style="font-size: 11px;"><?php echo e($assignment->teacher->branch); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-primary"><i class="bi bi-pin-map me-1"></i> <?php echo e($assignment->location->name); ?></div>
                                                <div class="text-white-50 small opacity-50 fw-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">
                                                    <i class="bi bi-layers me-1"></i> <?php echo e($assignment->location->floor ?? 'ZM'); ?>

                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="px-2 py-1 rounded bg-white bg-opacity-10 text-white-50 small border border-white border-opacity-10" style="font-size: 11px;">
                                                    <?php echo e($assignment->period_label); ?>

                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                    $statusClasses = [
                                                        'assigned' => 'bg-info',
                                                        'completed' => 'bg-success',
                                                        'absent' => 'bg-danger',
                                                        'swapped' => 'bg-warning text-dark'
                                                    ];
                                                    $cls = $statusClasses[$assignment->status] ?? 'bg-secondary';
                                                ?>
                                                <span class="badge <?php echo e($cls); ?> shadow-sm px-3 py-2" style="font-size: 10px; min-width: 90px;">
                                                    <?php echo e($assignment->status_label); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-4 opacity-10"><i class="bi bi-calendar-event" style="font-size: 80px;"></i></div>
                            <h5 class="text-light fw-bold">Henüz Bugün İçin Çizelge Yayınlanmadı</h5>
                            <p class="text-white-50 mb-4 px-5">Günlük nöbet akışını başlatmak için çizelge oluşturun veya mevcut bir taslağı yayınlayın.</p>
                            <a href="<?php echo e(route('schedules.create')); ?>" class="btn btn-primary px-5 py-3 rounded-3 shadow">
                                <i class="bi bi-plus-lg me-2"></i> Bugünün Çizelgesini Başlat
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Son İşlemler & Planlama Geçmişi (Yeni Görünüm) -->
            <div class="card border-0 shadow-lg">
                <div class="card-header py-3 px-4 border-0 d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Planlama Geçmişi</h6>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        <?php $__currentLoopData = $recentSchedules->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 border-bottom border-end border-light border-opacity-10">
                            <a href="<?php echo e(route('schedules.show', $schedule)); ?>" class="d-flex align-items-center gap-3 p-3 text-decoration-none transition-hover">
                                <div class="text-center p-2 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); min-width: 55px;">
                                    <div class="fw-black text-white h5 mb-0"><?php echo e($schedule->date->format('d')); ?></div>
                                    <div class="text-uppercase text-primary small fw-bold" style="font-size: 9px;"><?php echo e($schedule->date->locale('tr')->shortMonthName); ?></div>
                                </div>
                                <div style="min-width: 0;">
                                    <h6 class="text-white fw-bold mb-0 small text-truncate"><?php echo e($schedule->day_of_week); ?></h6>
                                    <div class="mt-1">
                                        <?php $sCls = $schedule->status === 'published' ? 'bg-success' : ($schedule->status === 'draft' ? 'bg-warning text-dark' : 'bg-info'); ?>
                                        <span class="badge <?php echo e($sCls); ?> rounded-pill px-2" style="font-size: 8px;"><?php echo e($schedule->status_label); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Kolon: Hızlı Atama (YENİ) & Kısayollar -->
        <div class="col-lg-4">
            <!-- HIZLI ATAMA FORMU -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(165deg, rgba(79, 70, 229, 0.1) 0%, rgba(15, 23, 42, 1) 100%) !important; border: 1px solid rgba(79, 70, 229, 0.2) !important;">
                <div class="card-header py-3 px-3 border-0 d-flex align-items-center gap-2">
                    <div class="p-1 rounded bg-primary text-white shadow-sm">
                        <i class="bi bi-lightning-charge-fill small"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-white small">Hızlı Nöbet Atama</h6>
                </div>
                <div class="card-body px-3 pb-3">
                    <form action="<?php echo e(route('assignments.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Nöbet Tarihi</label>
                            <input type="date" name="date" class="form-control bg-dark border-0 text-white py-2 shadow-sm" value="<?php echo e(date('Y-m-d')); ?>" style="font-size: 13px;" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Öğretmen Seçimi</label>
                            <select name="user_id" class="form-select bg-dark border-0 text-white py-2 shadow-sm" style="font-size: 13px;" required>
                                <option value="">Seçiniz...</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Nöbet Noktası</label>
                            <select name="location_id" class="form-select bg-dark border-0 text-white py-2 shadow-sm" style="font-size: 13px;" required>
                                <option value="">Belirleyin...</option>
                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Başlangıç</label>
                                <input type="time" name="start_time" class="form-control bg-dark border-0 text-white py-2 shadow-sm" value="08:00" style="font-size: 13px;">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 10px;">Bitiş</label>
                                <input type="time" name="end_time" class="form-control bg-dark border-0 text-white py-2 shadow-sm" value="11:30" style="font-size: 13px;">
                            </div>
                            <input type="hidden" name="period" value="custom">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 shadow-lg border-0 fw-bold small">
                            Hemen Görevlendir
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hızlı Kısayollar -->
            <div class="card border-0 shadow-lg">
                <div class="card-body p-3">
                    <h6 class="text-white fw-bold mb-3 small"><i class="bi bi-grid-fill me-2 text-primary"></i>Hızlı Eriş</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <a href="<?php echo e(route('schedules.create')); ?>" class="btn btn-dark w-100 py-2 rounded-3 border-0 d-flex align-items-center justify-content-between px-3 transition-hover" style="background: rgba(255,255,255,0.03);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar-plus text-primary fs-6"></i>
                                    <span class="small fw-bold text-white" style="font-size: 12px;">Çizelge Tanımla</span>
                                </div>
                                <i class="bi bi-chevron-right text-white-50 small" style="font-size: 10px;"></i>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('teachers.create')); ?>" class="btn btn-dark w-100 py-3 rounded-3 border-0 d-flex flex-column align-items-center gap-1 transition-hover" style="background: rgba(255,255,255,0.03);">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2"><i class="bi bi-person-plus text-info fs-6"></i></div>
                                <span class="small fw-bold text-white" style="font-size: 11px;">Öğretmen</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('locations.create')); ?>" class="btn btn-dark w-100 py-3 rounded-3 border-0 d-flex flex-column align-items-center gap-1 transition-hover" style="background: rgba(255,255,255,0.03);">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2"><i class="bi bi-plus-square text-warning fs-6"></i></div>
                                <span class="small fw-bold text-white" style="font-size: 11px;">Nokta</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { background: rgba(255,255,255,0.08) !important; transform: translateY(-2px); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .fw-black { font-weight: 900; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>