

<?php $__env->startSection('title', 'Dashboard - Nöbetçi Öğretmen Takip Sistemi'); ?>
<?php $__env->startSection('page-title', 'Hoş Geldiniz, ' . auth()->user()->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4">
        <!-- Bugünkü Nöbetlerim -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-calendar-day me-2 text-primary"></i>Bugünkü Nöbetlerim</h5>
                    <?php if($todaySchedule): ?>
                        <span class="badge-status badge-published"><?php echo e($todaySchedule->day_of_week); ?> - <?php echo e($todaySchedule->date->format('d.m.Y')); ?></span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if($myTodayDuties->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $myTodayDuties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div style="border: 1.5px solid #e8e8f0; border-radius: 12px; padding: 20px; transition: all 0.2s;" onmouseover="this.style.borderColor='#667eea'; this.style.boxShadow='0 4px 16px rgba(102,126,234,0.15)'" onmouseout="this.style.borderColor='#e8e8f0'; this.style.boxShadow='none'">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="badge-status badge-<?php echo e($duty->period); ?>"><?php echo e($duty->period_label); ?></span>
                                            <span class="badge-status badge-<?php echo e($duty->status); ?>"><?php echo e($duty->status_label); ?></span>
                                        </div>
                                        <h6 class="fw-bold mb-1">
                                            <i class="bi bi-geo-alt-fill text-primary me-1"></i>
                                            <?php echo e($duty->location->name); ?>

                                        </h6>
                                        <div style="font-size: 13px; color: #999;">
                                            <i class="bi bi-building me-1"></i><?php echo e($duty->location->floor ?? 'Belirtilmemiş'); ?>

                                        </div>
                                        <?php if($duty->start_time && $duty->end_time): ?>
                                            <div class="mt-2" style="font-size: 13px; color: #667eea; font-weight: 600;">
                                                <i class="bi bi-clock me-1"></i>
                                                <?php echo e(\Carbon\Carbon::parse($duty->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($duty->end_time)->format('H:i')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-emoji-smile d-block"></i>
                            <h5>Bugün nöbetiniz yok</h5>
                            <p>İyi çalışmalar dileriz!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Yaklaşan Nöbetlerim -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-week me-2 text-primary"></i>Yaklaşan Nöbetlerim</h5>
                </div>
                <div class="card-body">
                    <?php if($upcomingDuties->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table" id="upcomingDutiesTable">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Gün</th>
                                        <th>Nöbet Yeri</th>
                                        <th>Zaman</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $upcomingDuties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo e($duty->dutySchedule->date->format('d.m.Y')); ?></td>
                                            <td><?php echo e($duty->dutySchedule->day_of_week); ?></td>
                                            <td>
                                                <i class="bi bi-geo-alt text-primary me-1"></i>
                                                <?php echo e($duty->location->name); ?>

                                            </td>
                                            <td>
                                                <span class="badge-status badge-<?php echo e($duty->period); ?>"><?php echo e($duty->period_label); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge-status badge-<?php echo e($duty->status); ?>"><?php echo e($duty->status_label); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-calendar-x d-block"></i>
                            <h5>Yaklaşan nöbetiniz bulunmuyor</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sağ Panel -->
        <div class="col-lg-4">
            <!-- Takas Taleplerim -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2 text-warning"></i>Takas Taleplerim</h5>
                    <a href="<?php echo e(route('swap-requests.create')); ?>" class="btn btn-sm btn-primary-gradient">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if($mySwapRequests->count() > 0): ?>
                        <?php $__currentLoopData = $mySwapRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $swap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                                <div class="user-avatar" style="width:36px;height:36px;font-size:13px;border-radius:8px;flex-shrink:0;">
                                    <?php echo e(strtoupper(substr($swap->target->name, 0, 1))); ?>

                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold" style="font-size: 13px;"><?php echo e($swap->target->name); ?></div>
                                    <div style="font-size: 11px; color: #999;"><?php echo e($swap->dutyAssignment->location->name); ?></div>
                                </div>
                                <span class="badge-status badge-<?php echo e($swap->status); ?>"><?php echo e($swap->status_label); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="p-4 text-center">
                            <p class="text-muted mb-2" style="font-size: 13px;">Henüz takas talebiniz yok.</p>
                            <a href="<?php echo e(route('swap-requests.create')); ?>" class="btn btn-sm btn-primary-gradient">
                                <i class="bi bi-plus-lg me-1"></i>Takas Talebi Oluştur
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/dashboard/teacher.blade.php ENDPATH**/ ?>