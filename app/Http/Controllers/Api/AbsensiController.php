<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PegawaiPerusahaan;
use App\Models\PhoneKeyPegawai;
use App\MyLibraries\RequestValidation\RequestValidation;
use App\Models\User;
use App\MyLibraries\Generate\Id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AbsensiController extends Controller
{
    private function errMsg($err)
    {
        $err = json_encode($err);
        $errors = [];
        foreach (json_decode($err) as $key => $value) {
            $errors[] = $value[0];
        }

        return $errors;
    }

    public function changeProfile(Request $request, $phone_key)
    {
        $phoneKey = PhoneKeyPegawai::where('phone_key', $phone_key)->first();
        $pegawai = $phoneKey->pegawaiPerusahaan;
        if (isset($pegawai)) {
            $validEmail = true;
            if (isset($request->email_pegawai)) {
                $countPegawai = PegawaiPerusahaan::where('email_pegawai', $request->email_pegawai)->count();
                $countUser = User::where('email', $request->email_pegawai)->count();
                $validEmail = $pegawai->email_pegawai != $request->email_pegawai && $countPegawai == 0 && $countUser == 0;
                if (!$validEmail) {
                    return response([
                        'stat' => 0,
                        'err' => ['email telah ada sebelumnya'],
                    ], 400);
                }
            }
            $pegawai->update([
                'nama_pegawai' => $request->get('nama_pegawai', $pegawai->nama_pegawai),
                'bidang_pegawai' => $request->get('bidang_pegawai', $pegawai->bidang_pegawai),
                'unit_pegawai' => $request->get('unit_pegawai', $pegawai->unit_pegawai),
                'email_pegawai' => $request->get('email_pegawai', $request->email_pegawai),
                'no_telpon' => $request->get('no_telpon', $pegawai->no_telpon),
            ]);

            return response([
                'stat' => 1,
                'data' => $pegawai,
                'msg' => 'berhasil ubah profile',
            ], 200);
        } else {
            return response([
                'stat' => 0,
                'err' => ['nip tidak di temukan'],
            ], 400);
        }
    }

    // change password
    public function changePassword(Request $request, $phone_key)
    {
        return RequestValidation::valid(['request' => $request, 'rule' => [
            'password_lama' => ['required'],
            'password_baru' => ['required'],
        ]], function ($request) use ($phone_key) {
            $phoneKey = PhoneKeyPegawai::where('phone_key', $phone_key)->first();
            $pegawai = $phoneKey->pegawaiPerusahaan;
            if (isset($pegawai) && Hash::check($request->password_lama, $pegawai->password)) {
                $pegawai->update([
                    'password' => Hash::make($request->password_baru),
                ]);

                return response([
                    'stat' => 1,
                    'data' => $pegawai,
                    'msg' => 'berhasil ubah password',
                ]);
            } else {
                return response([
                    'stat' => 0,
                    'err' => ['phone key atau password lama tidak ada yang cocok'],
                ], 400);
            }
        }, function ($err) {
            return response([
                'stat' => 0,
                'err' => RequestValidation::errMsg($err),
            ], 400);
        });
    }

    // login v2
    public function loginV2(Request $request)
    {
        return RequestValidation::valid([
            'request' => $request,
            'rule' => [
                'phone_key' => ['required', 'string'],
                // 'unique:phone_key_pegawai'
                'nip' => ['string'],
                'password' => ['string'],
            ],
        ], function ($request) {
            $pegawai_perusahaan = PegawaiPerusahaan::where('nip_pegawai', $request->nip)->first();

            if (!isset($pegawai_perusahaan)) {
                return response([
                    'msg' => [
                        "Tidak ada karyawan dengan nip {$request->nip}",
                        "Segera periksa nip anda kembali !",
                    ],
                    'data' => null,
                    'err' => null,
                ], 400);
            }

            if (!Hash::check($request->password, $pegawai_perusahaan->password)) {
                return response([
                    'msg' => [
                        'Login gagal',
                        'Segera periksa kembali nip dan password anda!',
                    ],
                    'data' => null,
                    'err' => null,
                ], 400);
            }

            $phone_key = PhoneKeyPegawai::where('id_pegawai_perusahaan', $pegawai_perusahaan->id);
            $phone_key_count = $phone_key->count();
            $max_register_phone_key = env('MAX_REGISTER_PHONE_KEY', 10);
            if ($phone_key_count >= $max_register_phone_key) {
                return response([
                    'status' => 0,
                    'msg' => [
                        "Maaf perangkat yang kamu gunakan telah di gunakan oleh {$max_register_phone_key} akun"
                    ],
                ], 400);
            }

            $phone_key_pegawai = $phone_key
                ->where('id_pegawai_perusahaan', $pegawai_perusahaan->id)
                ->where('phone_key', $request->phone_key)
                ->first();

            if (!isset($phone_key_pegawai)) {
                $phone_key_pegawai = PhoneKeyPegawai::create([
                    'id' => Id::generate(new PhoneKeyPegawai()),
                    'id_pegawai_perusahaan' => $pegawai_perusahaan->id,
                    'phone_key' => $request->phone_key,
                ]);
            }

            $pegawai = $phone_key_pegawai->pegawaiPerusahaan;
            $peserta = $pegawai->pesertaRaker;

            if (!Hash::check($request->password, $pegawai->password)) {
                return response([
                    'msg' => 'Login Failed',
                    'data' => null,
                    'err' => null,
                ], 400);
            }

            $raker = [];
            foreach ($peserta as $key => $value) {
                $persetujaun = $value->raker->persetujuanRaker;
                if (isset($persetujaun)) {
                    if ($persetujaun->status_persetujuan_raker) {
                        $raker[] = [
                            'id' => $value->id_raker,
                            'nama_raker' => $value->raker->nama_raker,
                            'deskripsi_raker' => $value->raker->deskripsi_raker,
                            'tanggal_jam_masuk_raker' => $value->raker->tanggal_jam_masuk_raker,
                            'tanggal_jam_keluar_raker' => $value->raker->tanggal_jam_keluar_raker,
                            'jumlah_peserta_raker' => $value->raker->jumlah_peserta_raker,
                            'status_absensi' => $value->status_absensi,
                            'tanggal_jam_absensi' => date('d-m-Y H:i:s', strtotime($value->tanggal_jam_absensi)),
                            'keterangan_absensi' => $value->keterangan_absensi,
                            'sekretaris_bidang' => $value->raker->sekretarisBidang,
                            'ruangan' => $value->raker->ruangan,
                            'peserta_raker' => $value->raker->pesertaRaker->map(function ($item, $index) {
                                return PegawaiPerusahaan::find($item->id_pegawai_perusahaan);
                            }),
                            'notulen_raker' => PegawaiPerusahaan::where('nip_pegawai', $value->raker->notulenRaker->username)->first(),
                        ];
                    }
                }
            }

            return response([
                'status' => 1,
                'data' => [
                    'pegawai' => $pegawai,
                    'raker' => $raker,
                ],
                'msg' => ['sukses berhasil login'],
            ], 200);
        }, function ($err) {
            $response = [
                'status' => 0,
                'err' => $this->errMsg($err),
            ];

            return response($response, 400);
        });
    }

    // response 2x jika phone_key tidak terdaftar
    public function login(Request $request)
    {
        return RequestValidation::valid([
            'request' => $request,
            'rule' => [
                'phone_key' => [
                    'required',
                    'string',
                    // 'unique:phone_key_pegawai'
                ],
                'nip' => ['string'],
            ],
        ], function ($request) {
            $phoneKeyPegawai = new PhoneKeyPegawai();
            $loopStatus = 1;
            do {
                $phoneKey = $phoneKeyPegawai->where('phone_key', $request->phone_key)->first();
                if (!isset($phoneKey)) {
                    if (isset($request->nip)) {
                        $pegawai = PegawaiPerusahaan::where('nip_pegawai', $request->nip)->first();
                        if (isset($pegawai)) {
                            $checkPhoneKeyCreate = $phoneKeyPegawai->where('id_pegawai_perusahaan', $pegawai->id)->count() < 2;
                            if ($checkPhoneKeyCreate) {
                                $phoneKeyPegawai = $phoneKeyPegawai->create([
                                    'id_pegawai_perusahaan' => $pegawai->id,
                                    'phone_key' => $request->phone_key,
                                ]);
                            } else {
                                return response([
                                    'status' => 0,
                                    'err' => ['tidak dapat terdaftar dalam absensi'],
                                    'msg' => [
                                        'telah ada 2 phone yang terdaftar',
                                        'segera melapor pada admin untuk mereset nya',
                                    ],
                                ], 400);
                            }
                        } else {
                            return response([
                                'status' => 0,
                                'err' => ['Maaf nip tidak ada yang cocok'],
                                'msg' => ['mohon periksa nip kamu terlebih dahulu'],
                            ], 400);
                        }
                    } else {
                        return response([
                            'status' => 0,
                            'err' => ['Maaf phone key tidak ada yang cocok'],
                            'msg' => ['mohon isikan nip kamu terlebih dahulu'],
                        ], 400);
                    }
                } else {
                    $pegawai = $phoneKey->pegawaiPerusahaan;
                    $peserta = $pegawai->pesertaRaker;
                    $raker = [];
                    foreach ($peserta as $key => $value) {
                        $persetujaun = $value->raker->persetujuanRaker;
                        if (isset($persetujaun)) {
                            if ($persetujaun->status_persetujuan_raker) {
                                $raker[] = [
                                    'id' => $value->id_raker,
                                    'nama_raker' => $value->raker->nama_raker,
                                    'deskripsi_raker' => $value->raker->deskripsi_raker,
                                    'tanggal_jam_masuk_raker' => $value->raker->tanggal_jam_masuk_raker,
                                    'tanggal_jam_keluar_raker' => $value->raker->tanggal_jam_keluar_raker,
                                    'jumlah_peserta_raker' => $value->raker->jumlah_peserta_raker,
                                    'status_absensi' => $value->status_absensi,
                                    'tanggal_jam_absensi' => $value->tanggal_jam_absensi,
                                    'keterangan_absensi' => $value->keterangan_absensi,
                                ];
                            }
                        }
                    }

                    return response([
                        'status' => 1,
                        'data' => [
                            'pegawai' => $pegawai,
                            'raker' => $raker,
                        ],
                        'msg' => ['sukses berhasil login'],
                    ], 200);
                    $loopStatus = 0;
                }
            } while ($loopStatus);

            return response([
                'status' => 0,
                'err' => ['Maaf data karyawan tidak ada yang cocok'],
                'msg' => ['mohon isikan nip kamu terlebih dahulu'],
            ], 400);
        }, function ($err) {
            $response = [
                'status' => 0,
                'err' => $this->errMsg($err),
            ];

            return response($response, 400);
        });
    }

    public function absensi(Request $request)
    {
        return RequestValidation::valid([
            'request' => $request,
            'rule' => [
                'raker_qrcode' => ['required', 'numeric'],
                // send id
                'raker' => ['required', 'numeric'],
                // send id
                'phone_key' => ['required', 'string'],
                // nip
                'nip' => ['required'],
            ],
        ], function ($request) {
            $pegawai_perusahaan = PegawaiPerusahaan::where('nip_pegawai', $request->nip)->first();
            if (!isset($pegawai_perusahaan)) {
                return response([
                    'msg' => [
                        "Tidak ada karyawan dengan nip {$request->nip}",
                        "Segera periksa nip anda kembali !",
                    ],
                    'data' => null,
                    'err' => null,
                ], 400);
            }

            $raker_qrcode = $request->raker_qrcode;
            $raker = $request->raker;
            $phone_key = $request->phone_key;
            $phoneKeyPegawai = new PhoneKeyPegawai();
            $phoneKey = $phoneKeyPegawai
                ->where('id_pegawai_perusahaan', $pegawai_perusahaan->id)
                ->where('phone_key', $phone_key)
                ->first();

            if (isset($phoneKey)) {
                $pegawai = $phoneKey->pegawaiPerusahaan;
                if ($raker_qrcode == $raker) {
                    $peserta = $pegawai->pesertaRaker->where('id_raker', $raker)->first();
                    if (isset($peserta)) {
                        $raker = $peserta->raker;
                        if (!$peserta->status_absensi) {
                            date_default_timezone_set('Asia/Jakarta');
                            $waktuAbsen = date('Y-m-d H:i');
                            $intWaktuAbsen = strtotime($waktuAbsen);
                            $intWaktuMasukRaker = strtotime($raker->tanggal_jam_masuk_raker);
                            $keteranganAbsensi = 'TELAT';
                            if ($intWaktuAbsen <= $intWaktuMasukRaker) {
                                $keteranganAbsensi = 'TEPAT WAKTU';
                            }
                            $peserta->update([
                                'status_absensi' => 1,
                                'tanggal_jam_absensi' => $waktuAbsen,
                                'keterangan_absensi' => $keteranganAbsensi,
                            ]);

                            return response([
                                'status' => 1,
                                'data' => [
                                    'peserta' => $peserta,
                                    'raker' => $raker,
                                ],
                                'msg' => ['anda telah absen'],
                            ], 200);
                        } else {
                            return response([
                                'status' => 1,
                                'data' => [
                                    'peserta' => $peserta,
                                    'raker' => $raker,
                                ],
                                'msg' => ['anda telah absen sebelumnya'],
                            ], 200);
                        }
                    } else {
                        return response([
                            'status' => 0,
                            'err' => ['maaf kamu tidak terdaftar dalam raker ini'],
                            'msg' => ['mohon pilih raker yang sesui'],
                        ], 400);
                    }
                } else {
                    return response([
                        'status' => 0,
                        'err' => ['maaf code qrcode scann tidak cocok'],
                        'msg' => ['mohon pilih raker yang sesui'],
                    ], 400);
                }
            }

            return response([
                'status' => 0,
                'err' => ['Maaf data karyawan tidak ada yang cocok'],
                'msg' => ['mohon isikan nip kamu terlebih dahulu'],
            ], 400);
        }, function ($err) {
            $response = [
                'status' => 0,
                'err' => $this->errMsg($err),
            ];

            return response($response, 400);
        });
    }
}
