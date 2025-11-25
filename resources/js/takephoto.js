import React from "react";
import { createRoot } from "react-dom/client";

/**
 *
 *
 * @param {{ el : HTMLElement }} props
 * @return {*}
 */
function InputTakePhoto({ el }) {
    const isInvalid = el.getAttribute("valid") == "is-invalid";

    const { availWidth, availHeight } = window.screen;
    /** @type {{ current? : HTMLVideoElement }} */
    const videoEl = React.useRef();
    /** @type {{ current? : HTMLInputElement }} */
    const inputFileEl = React.useRef();

    /** @type {[MediaStream, (videoStream :  MediaStream) => void]} */
    const [videoStream, setVideoStream] = React.useState(null);
    const [activePhotoScreen, setActivePhotoScreen] = React.useState(false);
    const [imageFile, setImageFile] = React.useState(null);

    const handleOpenCamera = () => {
        navigator.mediaDevices
            .getUserMedia({
                audio: false,
                video: true,
            })
            .then((videoStream) => {
                setVideoStream(videoStream);
                videoEl.current.srcObject = videoStream;
                return videoEl.current?.play();
            })
            .catch((e) => {
                console.error("[errors] getUserMedia", e.message);
                videoEl.current?.pause();
            });
    };

    const handleClickTakePhoto = () => {
        setActivePhotoScreen(true);
        handleOpenCamera();
    };

    const handleCameraBtnTakePhoto = () => {
        const canvas = document.createElement("canvas");
        canvas.height = availHeight / 2;
        canvas.width = availWidth / 2;
        canvas
            .getContext("2d")
            .drawImage(videoEl.current, 0, 0, canvas.width, canvas.height);

        handleRemoveAllFileFromInputFile();
        canvas.toBlob((blob) => {
            const file = new File([blob], new Date().getTime());
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            setImageFile(file);
            inputFileEl.current.files = dataTransfer.files;
        });

        videoEl.current.pause();
        videoStream.getTracks().forEach((track) => track.stop());
    };

    const handleBtnClose = () => {
        videoEl.current?.pause();
        videoStream.getTracks().forEach((track) => track.stop());
        setActivePhotoScreen(false);
        setImageFile(null);
    };

    const handleBtnReTakeCamera = () => {
        setImageFile(null);
        handleOpenCamera();
    };

    const handleRemoveAllFileFromInputFile = () => {
        const files = [...inputFileEl.current.files];
        files.splice(0, 1);
    };

    const handleCompliteCameraTake = () => {
        videoStream.getTracks().forEach((track) => track.stop());
        setActivePhotoScreen(false);
    };

    return (
        <React.Fragment>
            {activePhotoScreen && (
                <div
                    style={{
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0,
                        zIndex: 1035,
                        position: "fixed",
                        backgroundColor: "rgba(0,0,0,0.7)",
                        width: "100vw",
                        height: "100vh",
                        display: "flex",
                        justifyContent: "center",
                        alignItems: "center",
                    }}
                >
                    {!imageFile ? (
                        <video
                            style={{
                                width: availWidth,
                                height: availHeight,
                            }}
                            ref={videoEl}
                        ></video>
                    ) : (
                        <img src={URL.createObjectURL(imageFile)} />
                    )}
                    <div
                        style={{
                            position: "absolute",
                            width: "100%",
                            top: 50,
                            right: 50,
                        }}
                    >
                        <div style={{ display: "flex", justifyContent: "end" }}>
                            <button
                                onClick={handleBtnClose}
                                type="button"
                                className="btn  text-white"
                            >
                                <i className="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div
                        style={{
                            position: "absolute",
                            width: "100%",
                            bottom: 50,
                        }}
                    >
                        <div
                            style={{
                                display: "flex",
                                justifyContent: "center",
                            }}
                        >
                            {!imageFile ? (
                                <button
                                    type="button"
                                    onClick={handleCameraBtnTakePhoto}
                                    className="btn btn-primary btn-lg"
                                >
                                    <i className="fa fa-camera"></i>
                                </button>
                            ) : (
                                <div className="btn-group">
                                    <button
                                        type="button"
                                        onClick={handleBtnReTakeCamera}
                                        className="btn btn-primary btn-lg"
                                    >
                                        <i className="fa fa-camera"></i>
                                    </button>
                                    <button
                                        type="button"
                                        onClick={handleCompliteCameraTake}
                                        className="btn btn-primary btn-lg"
                                    >
                                        <i className="fa fa-check"></i>
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            )}
            <input
                name={el.getAttribute("name") ?? null}
                ref={inputFileEl}
                type="file"
                style={{
                    display: "none",
                }}
            />

            {imageFile && (
                <img
                    className="w-100 mb-2"
                    src={URL.createObjectURL(imageFile)}
                />
            )}

            <button
                type="button"
                onClick={handleClickTakePhoto}
                style={{ border: isInvalid ? "1px solid red" : "none" }}
                className={`btn btn-primary`}
            >
                <i className="fa fa-camera"></i>
                {!imageFile ? " Ambil Foto" : " Ambil Ulang Foto"}
            </button>
        </React.Fragment>
    );
}

var inputs = document.getElementsByClassName("inputtakephoto");
for (var input of inputs) {
    createRoot(input).render(<InputTakePhoto el={input} />);
}
