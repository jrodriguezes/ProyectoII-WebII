<?php

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../models/ReservationModel.php';

$user = $_SESSION['user'];
?>

<div class="min-h-full w-full">
    <div>
        <?php include __DIR__ . "/layouts/navbar.php" ?>
    </div>

    <div class="ml-8">
        <div class="flex items-center">
            <div><?php include COMP_PATH . '/theme-toggle.php'; ?></div>
        </div>
        <div>
            <h1 class="text-2xl font-bold">Bienvenido, <?= htmlspecialchars($user['first_name']) ?> 👋</h1>
            <p class="text-gray-500">Tu rol actual es: <strong><?= htmlspecialchars($user['user_type']) ?></strong>
            </p>
        </div>
    </div>

    <!-- 🔹 este div “saca” la tabla hasta el borde derecho -->
    <?php if ($user['user_type'] == 'driver'): ?>
        <?php $reservations = getReservationsByDriver($user['id']); ?>
        <div class="w-full overflow-x-auto pr-0 -mr-4 sm:-mr-6 md:-mr-8 lg:-mr-10">
            <div class="p-8">
                <div class="overflow-x-auto w-full">
                    <table class="w-full border-collapse divide-y-2 divide-gray-200 dark:divide-gray-700 text-center">
                        <thead class="sticky top-0 bg-white dark:bg-gray-900">
                            <tr class="font-medium text-gray-900 dark:text-white">
                                <th>Reservation ID</th>
                                <th>Plate vehicle</th>
                                <th>Ride</th>
                                <th>Passenger ID</th>
                                <th>Passenger</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                            <?php if (empty($reservations)): ?>
                                <tr>
                                    <td colspan="8" class="px-3 py-2 text-gray-400">No bookings have been registered yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($reservations as $reservation): ?>
                                    <tr class="text-gray-900 dark:text-white">
                                        <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                                        <td><?= htmlspecialchars($reservation['vehicle_plate']) ?></td>
                                        <td>
                                            <?= htmlspecialchars($reservation['ride_name']) ?>
                                            From: <?= htmlspecialchars($reservation['origin']) ?>
                                            To: <?= htmlspecialchars($reservation['destination']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($reservation['passenger_id']) ?></td>
                                        <td><?= htmlspecialchars($reservation['passenger_first_name'] . ' ' . $reservation['passenger_last_name']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                                        <td><?= htmlspecialchars($reservation['created_at']) ?></td>

                                        <td class="px-4 py-3 text-center">
                                            <?php if ($reservation['status'] === 'pending'): ?>
                                                <div class="flex justify-center flex-wrap gap-3">

                                                    <!-- ✅ Accept -->
                                                    <form method="POST" action="/post/proxy.php">
                                                        <input type="hidden" name="reservation_id"
                                                            value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                        <input type="hidden" name="action" value="accept_reservation">
                                                        <button type="submit"
                                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Accept
                                                        </button>
                                                    </form>

                                                    <!-- ❌ Reject -->
                                                    <form method="POST" action="/post/proxy.php">
                                                        <input type="hidden" name="reservation_id"
                                                            value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                        <input type="hidden" name="action" value="reject_reservation">
                                                        <button type="submit"
                                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>

                                                    <!-- 🗑 Delete -->
                                                    <form method="POST" action="/post/proxy.php">
                                                        <input type="hidden" name="reservation_id"
                                                            value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                        <input type="hidden" name="action" value="cancel_reservation">
                                                        <button type="submit"
                                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h12a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM5 6a1 1 0 011 1v9a2 2 0 002 2h4a2 2 0 002-2V7a1 1 0 112 0v9a4 4 0 01-4 4H8a4 4 0 01-4-4V7a1 1 0 011-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    <?php elseif ($user['user_type'] === 'passenger'): ?>
        <?php $reservations = getReservationsByPassenger($user['id']); ?>


        <div class="w-full overflow-x-auto pr-0 -mr-4 sm:-mr-6 md:-mr-8 lg:-mr-10">

            <table class="w-full table-fixed border-collapse divide-y-2 divide-gray-200 dark:divide-gray-700 text-center">
                <thead class="sticky top-0 bg-white dark:bg-gray-900">
                    <tr class="font-medium text-gray-900 dark:text-white">
                        <th>Reservation ID</th>
                        <th>Ride</th>
                        <th>Driver ID</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="w-[160px] text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    <?php if (empty($reservations)): ?>
                        <tr class="*:text-gray-900 *:first:font-medium dark:*:text-white ">
                            <td class="px-3 py-2 whitespace-nowrap">No bookings have been registered yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr class="text-gray-900 dark:text-white">
                                <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                                <td><?= htmlspecialchars($reservation['vehicle_plate']) ?></td>
                                <td>
                                    <?= htmlspecialchars($reservation['ride_name']) ?>
                                    From: <?= htmlspecialchars($reservation['origin']) ?>
                                    To: <?= htmlspecialchars($reservation['destination']) ?>
                                </td>
                                <td><?= htmlspecialchars($reservation['passenger_id']) ?></td>
                                <td><?= htmlspecialchars($reservation['passenger_first_name'] . ' ' . $reservation['passenger_last_name']) ?>
                                </td>
                                <td><?= htmlspecialchars($reservation['status']) ?></td>
                                <td><?= htmlspecialchars($reservation['created_at']) ?></td>

                                <!-- 🔹 celda de acciones compacta -->
                                <td class="w-[160px] max-w-[160px] text-center whitespace-nowrap overflow-hidden">
                                    <?php if ($reservation['status'] === 'pending'): ?>
                                        <div class="flex justify-center items-center space-x-2">
                                            <!-- Cancel -->
                                            <form method="POST" action="/post/proxy.php">
                                                <input type="hidden" name="reservation_id"
                                                    value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                <input type="hidden" name="action" value="cancel_reservation">
                                                <button type="submit"
                                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h12a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM5 6a1 1 0 011 1v9a2 2 0 002 2h4a2 2 0 002-2V7a1 1 0 112 0v9a4 4 0 01-4 4H8a4 4 0 01-4-4V7a1 1 0 011-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($user['user_type'] == 'driver&passenger'): ?>
        <?php $reservations = getReservationsByDriver($user['id']); ?>
        <div class="w-full overflow-x-auto pr-0 -mr-4 sm:-mr-6 md:-mr-8 lg:-mr-10">
            <div class="ml-8">
                <h2>Rides como Driver</h2>
            </div>
            <div class="p-8">
                <div class="overflow-x-auto w-full">
                    <table class="w-full border-collapse divide-y-2 divide-gray-200 dark:divide-gray-700 text-center">
                        <thead class="sticky top-0 bg-white dark:bg-gray-900">
                            <tr class="font-medium text-gray-900 dark:text-white">
                                <th>Reservation ID</th>
                                <th>Plate vehicle</th>
                                <th>Ride</th>
                                <th>Passenger ID</th>
                                <th>Passenger</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                            <?php if (empty($reservations)): ?>
                                <tr>
                                    <td colspan="8" class="px-3 py-2 text-gray-400">No bookings have been registered yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($reservations as $reservation): ?>
                                    <tr class="text-gray-900 dark:text-white">
                                        <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                                        <td><?= htmlspecialchars($reservation['vehicle_plate']) ?></td>
                                        <td>
                                            <?= htmlspecialchars($reservation['ride_name']) ?>
                                            From: <?= htmlspecialchars($reservation['origin']) ?>
                                            To: <?= htmlspecialchars($reservation['destination']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($reservation['passenger_id']) ?></td>
                                        <td><?= htmlspecialchars($reservation['passenger_first_name'] . ' ' . $reservation['passenger_last_name']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                                        <td><?= htmlspecialchars($reservation['created_at']) ?></td>

                                        <td class="px-4 py-3 text-center">
                                            <?php if ($reservation['status'] === 'pending'): ?>
                                                <div class="flex justify-center flex-wrap gap-3">

                                                    <!-- ✅ Accept -->
                                                    <form method="POST" action="/post/proxy.php">
                                                        <input type="hidden" name="reservation_id"
                                                            value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                        <input type="hidden" name="action" value="accept_reservation">
                                                        <button type="submit"
                                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Accept
                                                        </button>
                                                    </form>

                                                    <!-- ❌ Reject -->
                                                    <form method="POST" action="/post/proxy.php">
                                                        <input type="hidden" name="reservation_id"
                                                            value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                        <input type="hidden" name="action" value="reject_reservation">
                                                        <button type="submit"
                                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>

                                                    <!-- 🗑 Delete -->
                                                    <form method="POST" action="/post/proxy.php">
                                                        <input type="hidden" name="reservation_id"
                                                            value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                        <input type="hidden" name="action" value="cancel_reservation">
                                                        <button type="submit"
                                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h12a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM5 6a1 1 0 011 1v9a2 2 0 002 2h4a2 2 0 002-2V7a1 1 0 112 0v9a4 4 0 01-4 4H8a4 4 0 01-4-4V7a1 1 0 011-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <?php $reservations = getReservationsByPassenger($user['id']); ?>


        <div class="w-full overflow-x-auto pr-0 -mr-4 sm:-mr-6 md:-mr-8 lg:-mr-10">
            <div class="ml-8">
                <h2>Rides como Passenger</h2>
            </div>

            <table class="w-full table-fixed border-collapse divide-y-2 divide-gray-200 dark:divide-gray-700 text-center">
                <thead class="sticky top-0 bg-white dark:bg-gray-900">
                    <tr class="font-medium text-gray-900 dark:text-white">
                        <th>Reservation ID</th>
                        <th>Ride</th>
                        <th>Driver ID</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="w-[160px] text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    <?php if (empty($reservations)): ?>
                        <tr class="*:text-gray-900 *:first:font-medium dark:*:text-white ">
                            <td class="px-3 py-2 whitespace-nowrap">No bookings have been registered yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr class="text-gray-900 dark:text-white">
                                <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                                <td><?= htmlspecialchars($reservation['vehicle_plate']) ?></td>
                                <td>
                                    <?= htmlspecialchars($reservation['ride_name']) ?>
                                    From: <?= htmlspecialchars($reservation['origin']) ?>
                                    To: <?= htmlspecialchars($reservation['destination']) ?>
                                </td>
                                <td><?= htmlspecialchars($reservation['passenger_id']) ?></td>
                                <td><?= htmlspecialchars($reservation['passenger_first_name'] . ' ' . $reservation['passenger_last_name']) ?>
                                </td>
                                <td><?= htmlspecialchars($reservation['status']) ?></td>
                                <td><?= htmlspecialchars($reservation['created_at']) ?></td>

                                <!-- 🔹 celda de acciones compacta -->
                                <td class="w-[160px] max-w-[160px] text-center whitespace-nowrap overflow-hidden">
                                    <?php if ($reservation['status'] === 'pending'): ?>
                                        <div class="flex justify-center items-center space-x-2">
                                            <!-- Cancel -->
                                            <form method="POST" action="/post/proxy.php">
                                                <input type="hidden" name="reservation_id"
                                                    value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                                                <input type="hidden" name="action" value="cancel_reservation">
                                                <button type="submit"
                                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="me-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h12a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM5 6a1 1 0 011 1v9a2 2 0 002 2h4a2 2 0 002-2V7a1 1 0 112 0v9a4 4 0 01-4 4H8a4 4 0 01-4-4V7a1 1 0 011-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>