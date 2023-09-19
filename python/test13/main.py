import subprocess

def transcode_avi_to_mp4(input_file, output_file):
    try:
        # Run the ffmpeg command to transcode AVI to MP4
        subprocess.run(['ffmpeg', '-i', input_file, '-c:v', 'libx264', '-c:a', 'aac', '-strict', 'experimental', output_file], check=True)
        print(f"Transcoding complete. Output file: {output_file}")
    except subprocess.CalledProcessError as e:
        print(f"Error during transcoding: {e}")
    except FileNotFoundError:
        print("ffmpeg command not found. Please install ffmpeg.")

if __name__ == "__main__":
    input_file = "input.avi"  # Replace with the path to your AVI file
    output_file = "output.mp4"  # Replace with the desired output file path
    transcode_avi_to_mp4(input_file, output_file)
