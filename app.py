from flask import Flask, render_template, jsonify

app = Flask(__name__)

# Initial state
user_earnings = 0

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/click', methods=['POST'])
def click():
    global user_earnings
    user_earnings += 1  # Increment earnings for each click
    return jsonify({'earnings': user_earnings})

if __name__ == '__main__':
    app.run(debug=True)
