<?php $__env->startSection('title', ($schedule->title ?? $schedule->date->format('d.m.Y') . ' Nöbet Çizelgesi')); ?>
<?php $__env->startSection('page-title'); ?>
    <span class="text-white-50 fw-light">Çizelge Detayı:</span> <?php echo e($schedule->date->format('d.m.Y')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Üst Kontrol Paneli -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-primary">
                        <i class="bi bi-calendar2-week-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-white"><?php echo e($schedule->title ?? $schedule->date->format('d.m.Y') . ' Nöbet Çizelgesi'); ?></h4>
                        <div class="d-flex flex-wrap gap-3 align-items-center mt-1">
                            <span class="badge bg-dark border border-secondary text-light px-3 py-1" style="font-size: 11px;">
                                <i class="bi bi-calendar me-1"></i> <?php echo e($schedule->date->format('d.m.Y')); ?>

                            </span>
                            <span class="badge bg-dark border border-secondary text-light px-3 py-1" style="font-size: 11px;">
                                <i class="bi bi-person me-1"></i> <?php echo e($schedule->creator->name ?? 'Sistem'); ?>

                            </span>
                            <?php
                                $stCls = $schedule->status === 'published' ? 'bg-success' : ($schedule->status === 'draft' ? 'bg-warning text-dark' : 'bg-info');
                            ?>
                            <span class="badge <?php echo e($stCls); ?> px-3 py-1" style="font-size: 11px;">
                                <?php echo e($schedule->status === 'draft' ? 'Taslak' : ($schedule->status === 'published' ? 'Yayında' : 'Tamamlandı')); ?>

                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <button id="exportPdfBtn" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-lg border-0">
                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF Olarak İndir
                    </button>
                    
                    <?php if($schedule->isDraft()): ?>
                        <form action="<?php echo e(route('schedules.publish', $schedule)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-success d-flex align-items-center gap-2 px-4 border-0">
                                <i class="bi bi-send-check"></i> Yayına Al
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <div class="dropdown">
                        <button class="btn btn-dark border-secondary px-3" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end bg-dark border-secondary">
                            <li><a class="dropdown-item text-light" href="<?php echo e(route('schedules.edit', $schedule)); ?>"><i class="bi bi-pencil me-2"></i>Düzenle</a></li>
                            <li><a class="dropdown-item text-light" href="<?php echo e(route('public.board')); ?>" target="_blank"><i class="bi bi-display me-2"></i>TV Görünümü</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <?php if($schedule->notes): ?>
                <div class="mt-4 p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                    <small class="text-white-50 d-block mb-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1px;">Notlar:</small>
                    <div class="text-white small"><?php echo e($schedule->notes); ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4">
        <!-- Nöbet Programı İçeriği (PDF'e aktarılacak alan) -->
        <div class="col-lg-8" id="scheduleTableArea">
            <div class="pdf-export-header d-none">
                <h2 style="color: black; margin-bottom: 20px;"><?php echo e($schedule->title ?? 'Nöbet Çizelgesi'); ?></h2>
                <p style="color: black;">Tarih: <?php echo e($schedule->date->format('d.m.Y')); ?> | Gün: <?php echo e($schedule->day_of_week); ?></p>
                <hr>
            </div>

            <?php $__currentLoopData = ['morning' => 'Sabah Periyodu (08:00 - 11:30)', 'noon' => 'Öğle Arası (11:30 - 13:30)', 'afternoon' => 'İkindi / Çıkış (13:30 - 17:20)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-4 border-0 bg-dark overflow-hidden shadow-sm" style="background: rgba(15, 23, 42, 0.4) !important; border: 1px solid rgba(255,255,255,0.05) !important;">
                    <div class="card-header border-bottom border-light border-opacity-10 py-3 px-4 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold text-white">
                            <?php if($period === 'morning'): ?> <i class="bi bi-brightness-alt-high text-warning me-2"></i>
                            <?php elseif($period === 'noon'): ?> <i class="bi bi-sun-fill text-info me-2"></i>
                            <?php else: ?> <i class="bi bi-moon-stars text-primary me-2"></i>
                            <?php endif; ?>
                            <?php echo e($label); ?>

                        </h6>
                        <span class="text-white-50 small"><?php echo e(($groupedAssignments[$period] ?? collect())->count()); ?> Görevli</span>
                    </div>
                    <div class="card-body p-0">
                        <?php if(isset($groupedAssignments[$period]) && $groupedAssignments[$period]->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table align-middle text-white mb-0">
                                    <thead class="bg-dark bg-opacity-50">
                                        <tr>
                                            <th class="ps-4 text-white-50">Öğretmen</th>
                                            <th class="text-white-50">Nöbet Yeri</th>
                                            <th class="text-white-50">Saat Aralığı</th>
                                            <th class="text-end pe-4 text-white-50">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $groupedAssignments[$period]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="user-avatar" style="width:32px;height:32px;font-size:12px;border-radius:10px;">
                                                            <?php echo e(strtoupper(substr($assignment->teacher->name, 0, 1))); ?>

                                                        </div>
                                                        <div class="fw-medium text-white"><?php echo e($assignment->teacher->name); ?></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge border border-secondary text-primary px-3 py-1" style="font-size: 11px;">
                                                        <i class="bi bi-geo-alt me-1"></i> <?php echo e($assignment->location->name); ?>

                                                    </span>
                                                </td>
                                                <td class="text-white-50 small">
                                                    <?php if($assignment->start_time && $assignment->end_time): ?>
                                                        <?php echo e(\Carbon\Carbon::parse($assignment->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($assignment->end_time)->format('H:i')); ?>

                                                    <?php else: ?>
                                                        Program Dahilinde
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <form id="del-<?php echo e($assignment->id); ?>" action="<?php echo e(route('assignments.destroy', $assignment)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                            <button type="button" class="btn btn-sm btn-dark border-0 p-2" onclick="confirmDelete('del-<?php echo e($assignment->id); ?>', 'Görev kaydı')">
                                                                <i class="bi bi-trash3 text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="p-4 text-center text-white-50 small">
                                <i class="bi bi-dash-circle me-1"></i> Bu periyot için henüz atama yapılmadı.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Atama Formu Bölümü -->
        <div class="col-lg-4">
            <div class="card border-0 bg-primary bg-opacity-10 shadow-lg overflow-hidden" style="border: 1px dashed rgba(79, 70, 229, 0.3) !important; position: sticky; top: 100px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center gap-3">
                    <div class="p-2 rounded bg-primary text-white shadow-sm">
                        <i class="bi bi-lightning-fill"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-white">Hızlı Atama Ekle</h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo e(route('assignments.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="duty_schedule_id" value="<?php echo e($schedule->id); ?>">
                        
                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Öğretmen Seçimi</label>
                            <select class="form-select border-0 bg-dark text-white py-3 shadow-sm" name="user_id" required>
                                <option value="">Bir öğretmen seçin...</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Nöbet Konumu</label>
                            <select class="form-select border-0 bg-dark text-white py-3 shadow-sm" name="location_id" required>
                                <option value="">Bir konum belirleyin...</option>
                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?> (<?php echo e($location->floor); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Zaman Periyodu</label>
                            <select class="form-select border-0 bg-dark text-white py-3 shadow-sm" id="pd-select" name="period" required>
                                <option value="morning">Sabah (08:00 - 11:30)</option>
                                <option value="noon">Öğle (11:30 - 13:30)</option>
                                <option value="afternoon">Öğleden Sonra (13:30 - 16:00)</option>
                                <option value="custom">Manuel / Özel</option>
                            </select>
                        </div>

                        <div class="row g-2 mb-5">
                            <div class="col-6">
                                <label class="form-label text-white-50 small fw-bold text-uppercase">Başlangıç</label>
                                <input type="time" class="form-control border-0 bg-dark text-white py-3 shadow-sm" id="st-time" name="start_time" value="08:00">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-white-50 small fw-bold text-uppercase">Bitiş</label>
                                <input type="time" class="form-control border-0 bg-dark text-white py-3 shadow-sm" id="en-time" name="end_time" value="11:30">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 shadow border-0 fw-bold">
                            Listeye Ekle <i class="bi bi-plus-lg ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdSelect = document.getElementById('pd-select');
        const stInput = document.getElementById('st-time');
        const enInput = document.getElementById('en-time');

        pdSelect.addEventListener('change', function() {
            if (this.value === 'morning') { stInput.value = '08:00'; enInput.value = '11:30'; }
            else if (this.value === 'noon') { stInput.value = '11:30'; enInput.value = '13:30'; }
            else if (this.value === 'afternoon') { stInput.value = '13:30'; enInput.value = '17:20'; }
        });

        // PDF Export Logic
        document.getElementById('exportPdfBtn').addEventListener('click', function() {
            const element = document.getElementById('scheduleTableArea');
            const opt = {
                margin: 1,
                filename: 'nobet-cizelgesi-<?php echo e($schedule->date->format('d-m-Y')); ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Temporarily style for white background for PDF readability
            const darkCards = element.querySelectorAll('.card');
            darkCards.forEach(c => {
                c.style.backgroundColor = 'white';
                c.style.color = 'black';
                c.style.border = '1px solid #eee';
            });
            const textLights = element.querySelectorAll('.text-white, .text-light, .fw-medium, .fw-bold, h6, h5');
            textLights.forEach(t => t.style.color = 'black');
            
            html2pdf().set(opt).from(element).save().then(() => {
                // Restore styles
                darkCards.forEach(c => c.removeAttribute('style'));
                textLights.forEach(t => t.removeAttribute('style'));
            });
        });
    });
</script>
<style>
    /* Table styling helpers */
    .table thead th { border-top: 0; background: rgba(255,255,255,0.02); color: rgba(255,255,255,0.5); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
    .table td { border-bottom: 1px solid rgba(255,255,255,0.05); }
    .transition-hover:hover { transform: translateY(-2px); transition: all 0.3s ease; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/schedules/show.blade.php ENDPATH**/ ?>